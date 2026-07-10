<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $restaurant = Restaurant::where('owner_id', auth()->id())->firstOrFail();
        $items = Item::where('restaurant_id', $restaurant->_id)->get();
        $categories = Category::where('restaurant_id', $restaurant->_id)->get();
        return view('admin.items.index', compact('items', 'categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|string',
            'name'        => 'required|string|max:150',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'old_price'   => 'nullable|numeric|min:0',
            'photo'       => 'nullable|image|max:2048',
            'tags'        => 'nullable|string', // comma-separated, e.g. "veg,spicy"
        ]);

        $restaurant = Restaurant::where('owner_id', auth()->id())->firstOrFail();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('items', 'public');
        }

        $data['tags'] = $data['tags'] ? array_map('trim', explode(',', $data['tags'])) : [];
        $data['restaurant_id'] = $restaurant->_id;
        $data['is_available'] = true;

        Item::create($data);

        return back()->with('success', 'Item added.');
    }

    public function update(Request $request, $id)
    {
        $item = $this->ownedItem($id);

        $data = $request->validate([
            'category_id' => 'required|string',
            'name'        => 'required|string|max:150',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'old_price'   => 'nullable|numeric|min:0',
            'photo'       => 'nullable|image|max:2048',
            'tags'        => 'nullable|string',
            'is_available' => 'nullable|boolean',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('items', 'public');
        }

        $data['tags'] = $data['tags'] ? array_map('trim', explode(',', $data['tags'])) : [];
        $data['is_available'] = $request->has('is_available');

        $item->update($data);

        return back()->with('success', 'Item updated.');
    }

    public function destroy($id)
    {
        $this->ownedItem($id)->delete();
        return back()->with('success', 'Item deleted.');
    }

    private function ownedItem($id)
    {
        $restaurant = Restaurant::where('owner_id', auth()->id())->firstOrFail();
        return Item::where('_id', $id)->where('restaurant_id', $restaurant->_id)->firstOrFail();
    }
}