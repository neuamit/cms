<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $restaurant = Restaurant::where('owner_id', auth()->id())->firstOrFail();
        $categories = Category::where('restaurant_id', $restaurant->_id)->orderBy('order')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|max:100']);
        $restaurant = Restaurant::where('owner_id', auth()->id())->firstOrFail();

        Category::create([
            'restaurant_id' => $restaurant->_id,
            'name' => $data['name'],
            'order' => Category::where('restaurant_id', $restaurant->_id)->count(),
        ]);

        return back()->with('success', 'Category added.');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate(['name' => 'required|string|max:100']);
        $category = $this->ownedCategory($id);
        $category->update($data);
        return back()->with('success', 'Category updated.');
    }

    public function destroy($id)
    {
        $this->ownedCategory($id)->delete();
        return back()->with('success', 'Category deleted.');
    }

    private function ownedCategory($id)
    {
        $restaurant = Restaurant::where('owner_id', auth()->id())->firstOrFail();
        return Category::where('_id', $id)->where('restaurant_id', $restaurant->_id)->firstOrFail();
    }
}