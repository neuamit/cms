<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use App\Models\Restaurant;

class DashboardController extends Controller
{
    public function index()
    {
        $restaurant = Restaurant::where('owner_id', auth()->id())->first();

        $totalCategories = 0;
        $totalItems = 0;

        if ($restaurant) {
            $totalCategories = Category::where('restaurant_id', $restaurant->_id)->count();
            $totalItems = Item::where('restaurant_id', $restaurant->_id)->count();
        }

        return view('admin.dashboard', compact('restaurant', 'totalCategories', 'totalItems'));
    }
}