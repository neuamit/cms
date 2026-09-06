<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnalyticsEvent;
use App\Models\Bill;
use App\Models\Category;
use App\Models\Item;
use App\Models\Restaurant;
use App\Models\TableRequest;
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
        $pendingRequests = 0;

        $salesToday = 0;
        $salesThisWeek = 0;
        $openBillsCount = 0;
        $billsClosedToday = 0;
        $avgBillToday = 0;

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

            $topItem = Item::where('restaurant_id', $restaurant->_id)
                ->orderBy('view_count', 'desc')
                ->first();

            $events = AnalyticsEvent::where('restaurant_id', $restaurant->_id)
                ->where('event_type', 'view')
                ->where('created_at', '>=', Carbon::now()->subDays(6)->startOfDay())
                ->get();

            for ($i = 6; $i >= 0; $i--) {
                $day = Carbon::now()->subDays($i);
                $chartLabels[] = $day->format('M d');
                $chartData[] = $events->filter(fn($e) => $e->created_at->isSameDay($day))->count();
            }

            $pendingRequests = TableRequest::where('restaurant_id', $restaurant->_id)
                ->where('status', 'pending')
                ->count();

            // Billing stats — only paid bills count as real revenue
            $paidBillsToday = Bill::where('restaurant_id', $restaurant->_id)
                ->where('status', 'paid')
                ->where('updated_at', '>=', Carbon::today())
                ->get();

            $paidBillsThisWeek = Bill::where('restaurant_id', $restaurant->_id)
                ->where('status', 'paid')
                ->where('updated_at', '>=', Carbon::now()->subDays(7))
                ->get();

            $salesToday = $paidBillsToday->sum('total');
            $salesThisWeek = $paidBillsThisWeek->sum('total');
            $billsClosedToday = $paidBillsToday->count();
            $avgBillToday = $billsClosedToday > 0 ? $salesToday / $billsClosedToday : 0;

            $openBillsCount = Bill::where('restaurant_id', $restaurant->_id)
                ->where('status', 'open')
                ->count();
        }

        return view('admin.dashboard', compact(
            'restaurant', 'totalCategories', 'totalItems', 'unavailableItems',
            'viewsToday', 'viewsThisWeek', 'topItem', 'chartLabels', 'chartData',
            'pendingRequests', 'salesToday', 'salesThisWeek', 'openBillsCount',
            'billsClosedToday', 'avgBillToday'
        ));
    }
}