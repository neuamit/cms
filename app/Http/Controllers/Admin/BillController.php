<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Item;
use App\Models\Restaurant;
use App\Models\TableRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BillController extends Controller
{
    // Table picker — shows which tables currently have unbilled requests
    public function index()
    {
        $restaurant = Restaurant::where('owner_id', auth()->id())->firstOrFail();

        $openTables = TableRequest::where('restaurant_id', $restaurant->_id)
            ->whereIn('status', ['pending', 'acknowledged'])
            ->get()
            ->pluck('table_number')
            ->unique()
            ->filter()
            ->values();

        $openBills = Bill::where('restaurant_id', $restaurant->_id)
            ->where('status', 'open')
            ->get()
            ->keyBy('table_number');

        return view('admin.bills.index', compact('restaurant', 'openTables', 'openBills'));
    }

    // The actual bill screen for one table
    public function show(Request $request, $tableNumber)
    {
        $restaurant = Restaurant::where('owner_id', auth()->id())->firstOrFail();

        $bill = Bill::where('restaurant_id', $restaurant->_id)
            ->where('table_number', $tableNumber)
            ->where('status', 'open')
            ->first();

        if (!$bill) {
            $bill = Bill::create([
                'restaurant_id' => $restaurant->_id,
                'table_number' => $tableNumber,
                'items' => [],
                'total' => 0,
                'status' => 'open',
            ]);
        }

        // Pull in anything the customer tapped "I'll have this" on, that isn't billed yet
        $pendingRequests = TableRequest::where('restaurant_id', $restaurant->_id)
            ->where('table_number', $tableNumber)
            ->whereIn('status', ['pending', 'acknowledged'])
            ->get();

        if ($pendingRequests->count()) {
            $items = $bill->items ?? [];

            foreach ($pendingRequests as $req) {
                $menuItem = Item::find($req->item_id);
                if (!$menuItem) continue;

                $existingIndex = collect($items)->search(fn($i) => $i['item_id'] === (string) $menuItem->_id);

                if ($existingIndex !== false) {
                    $items[$existingIndex]['quantity'] += 1;
                } else {
                    $items[] = [
                        'item_id' => (string) $menuItem->_id,
                        'name' => $menuItem->name,
                        'price' => $menuItem->price,
                        'quantity' => 1,
                    ];
                }

                $req->update(['status' => 'billed']);
            }

            $bill->update(['items' => $items, 'total' => $this->calculateTotal($items)]);
        }

        $allItems = Item::where('restaurant_id', $restaurant->_id)
            ->where('is_available', true)
            ->orderBy('name')
            ->get();

        return view('admin.bills.show', compact('bill', 'allItems', 'tableNumber'));
    }

    // Manually add an item (verbal order, or admin correction)
    public function addItem(Request $request, $billId)
    {
        $data = $request->validate([
            'item_id' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $bill = Bill::findOrFail($billId);
        $menuItem = Item::findOrFail($data['item_id']);

        $items = $bill->items ?? [];
        $existingIndex = collect($items)->search(fn($i) => $i['item_id'] === $data['item_id']);

        if ($existingIndex !== false) {
            $items[$existingIndex]['quantity'] += $data['quantity'];
        } else {
            $items[] = [
                'item_id' => (string) $menuItem->_id,
                'name' => $menuItem->name,
                'price' => $menuItem->price,
                'quantity' => $data['quantity'],
            ];
        }

        $bill->update(['items' => $items, 'total' => $this->calculateTotal($items)]);

        return back()->with('success', 'Item added.');
    }

    // Remove a line item entirely
    public function removeItem($billId, $itemId)
    {
        $bill = Bill::findOrFail($billId);
        $items = collect($bill->items ?? [])->reject(fn($i) => $i['item_id'] === $itemId)->values()->all();

        $bill->update(['items' => $items, 'total' => $this->calculateTotal($items)]);

        return back()->with('success', 'Item removed.');
    }

    // Adjust quantity on an existing line item
    public function updateQuantity(Request $request, $billId, $itemId)
    {
        $data = $request->validate(['quantity' => 'required|integer|min:1']);

        $bill = Bill::findOrFail($billId);
        $items = $bill->items ?? [];

        foreach ($items as &$item) {
            if ($item['item_id'] === $itemId) {
                $item['quantity'] = $data['quantity'];
                break;
            }
        }

        $bill->update(['items' => $items, 'total' => $this->calculateTotal($items)]);

        return back()->with('success', 'Quantity updated.');
    }

    public function markPaid($billId)
    {
        $bill = Bill::findOrFail($billId);
        $bill->update(['status' => 'paid']);

        return redirect()->route('admin.bills.index')->with('success', 'Bill closed and marked as paid.');
    }

    // Settled bill history, with optional date filter
    public function history(Request $request)
    {
        $restaurant = Restaurant::where('owner_id', auth()->id())->firstOrFail();

        $query = Bill::where('restaurant_id', $restaurant->_id)
            ->where('status', 'paid');

        if ($request->filled('date')) {
            $date = Carbon::parse($request->date);
            $query->where('updated_at', '>=', $date->copy()->startOfDay())
                  ->where('updated_at', '<=', $date->copy()->endOfDay());
        }

        $bills = $query->orderBy('updated_at', 'desc')->get();
        $totalRevenue = $bills->sum('total');

        return view('admin.bills.history', compact('bills', 'totalRevenue'));
    }

    // Reopen a settled bill so it can be edited via the normal bill screen
    public function reopen($billId)
    {
        $bill = Bill::findOrFail($billId);
        $bill->update(['status' => 'open']);

        return redirect()->route('admin.bills.show', $bill->table_number)
            ->with('success', 'Bill reopened for editing.');
    }

    private function calculateTotal(array $items): float
    {
        return collect($items)->sum(fn($i) => $i['price'] * $i['quantity']);
    }
}