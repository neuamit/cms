<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\AnalyticsEvent;
use App\Models\Category;
use App\Models\Item;
use App\Models\Restaurant;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::orderBy('created_at', 'desc')->get();
        return view('superadmin.restaurants.index', compact('restaurants'));
    }

    public function toggleActive(Request $request, $id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $restaurant->update(['is_active' => !$restaurant->is_active]);
        return back()->with('success', 'Restaurant status updated.');
    }

    public function show($id)
    {
        $restaurant = Restaurant::findOrFail($id);

        $totalCategories = Category::where('restaurant_id', $restaurant->_id)->count();
        $totalItems = Item::where('restaurant_id', $restaurant->_id)->count();
        $unavailableItems = Item::where('restaurant_id', $restaurant->_id)
            ->where('is_available', false)->count();

        $viewsToday = AnalyticsEvent::where('restaurant_id', $restaurant->_id)
            ->where('event_type', 'view')
            ->where('created_at', '>=', Carbon::today())
            ->count();

        $viewsThisWeek = AnalyticsEvent::where('restaurant_id', $restaurant->_id)
            ->where('event_type', 'view')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->count();

        $totalViewsAllTime = AnalyticsEvent::where('restaurant_id', $restaurant->_id)
            ->where('event_type', 'view')
            ->count();

        $topItem = Item::where('restaurant_id', $restaurant->_id)
            ->orderBy('view_count', 'desc')
            ->first();

        $chartLabels = [];
        $chartData = [];
        $events = AnalyticsEvent::where('restaurant_id', $restaurant->_id)
            ->where('event_type', 'view')
            ->where('created_at', '>=', Carbon::now()->subDays(6)->startOfDay())
            ->get();

        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::now()->subDays($i);
            $chartLabels[] = $day->format('M d');
            $chartData[] = $events->filter(fn($e) => $e->created_at->isSameDay($day))->count();
        }

        return view('superadmin.restaurants.show', compact(
            'restaurant', 'totalCategories', 'totalItems', 'unavailableItems',
            'viewsToday', 'viewsThisWeek', 'totalViewsAllTime', 'topItem',
            'chartLabels', 'chartData'
        ));
    }
}