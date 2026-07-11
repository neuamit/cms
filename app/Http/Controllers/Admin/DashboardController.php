<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnalyticsEvent;
use App\Models\Category;
use App\Models\Item;
use App\Models\Restaurant;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $restaurant = Restaurant::where('owner_id', auth()->id())->first();

        $totalCategories = 0;
        $totalItems = 0;
        $unavailableItems = 0;
        $viewsToday = 0;
        $viewsThisWeek = 0;
        $topItem = null;
        $chartLabels = [];
        $chartData = [];

        if ($restaurant) {
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

            // Top viewed item (all-time, using the running counter for speed)
            $topItem = Item::where('restaurant_id', $restaurant->_id)
                ->orderBy('view_count', 'desc')
                ->first();

            // Build a 7-day trend chart: one bucket per day
            $events = AnalyticsEvent::where('restaurant_id', $restaurant->_id)
                ->where('event_type', 'view')
                ->where('created_at', '>=', Carbon::now()->subDays(6)->startOfDay())
                ->get();

            for ($i = 6; $i >= 0; $i--) {
                $day = Carbon::now()->subDays($i);
                $chartLabels[] = $day->format('M d');
                $chartData[] = $events->filter(fn($e) => $e->created_at->isSameDay($day))->count();
            }
        }

        return view('admin.dashboard', compact(
            'restaurant', 'totalCategories', 'totalItems', 'unavailableItems',
            'viewsToday', 'viewsThisWeek', 'topItem', 'chartLabels', 'chartData'
        ));
    }
}