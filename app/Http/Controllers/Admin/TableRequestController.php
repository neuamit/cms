<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\TableRequest;
use App\Models\Item;
use Illuminate\Http\Request;

class TableRequestController extends Controller
{
    public function index()
    {
        $restaurant = Restaurant::where('owner_id', auth()->id())->firstOrFail();
        $requests = TableRequest::where('restaurant_id', $restaurant->_id)
            ->orderBy('created_at', 'desc')->limit(50)->get();

        $itemIds = $requests->pluck('item_id')->unique();
        $items = Item::whereIn('_id', $itemIds)->get()->keyBy(fn($i) => (string) $i->_id);

        return view('admin.table-requests.index', compact('requests', 'items'));
    }

    public function acknowledge($id)
    {
        TableRequest::findOrFail($id)->update(['status' => 'acknowledged']);
        return back();
    }
}