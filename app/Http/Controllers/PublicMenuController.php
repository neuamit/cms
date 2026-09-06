<?php

namespace App\Http\Controllers;

use App\Models\AnalyticsEvent;
use App\Models\Category;
use App\Models\Item;
use App\Models\Restaurant;
use App\Models\TableRequest;
use Illuminate\Http\Request;
use App\Services\TrendingService;
use App\Services\MenuSearchService;
use App\Services\RecommendationService;

class PublicMenuController extends Controller
{

    public function search(Request $request, $slug, MenuSearchService $search)
    {
        $restaurant = Restaurant::where('slug', $slug)->firstOrFail();
        $query = $request->query('q', '');

        $results = $search->search((string) $restaurant->_id, $query);

        return response()->json(
            $results->map(fn($item) => [
                'id' => (string) $item->_id,
                'name' => $item->name,
                'price' => $item->price,
                'photo' => $item->photo ? asset('storage/' . $item->photo) : null,
            ])
        );
    }

    public function recommendations($slug, $itemId, RecommendationService $recommender)
    {
        $restaurant = Restaurant::where('slug', $slug)->firstOrFail();
        $items = $recommender->getRecommendations((string) $restaurant->_id, $itemId);

        return response()->json(
            $items->map(fn($item) => [
                'id' => (string) $item->_id,
                'name' => $item->name,
                'price' => $item->price,
                'photo' => $item->photo ? asset('storage/' . $item->photo) : null,
            ])
        );
    }

    public function show($slug, TrendingService $trending)
    {
        $restaurant = Restaurant::where('slug', $slug)->firstOrFail();

        $trialActive = $restaurant->subscription_status === 'trial'
            && $restaurant->trial_ends_at
            && $restaurant->trial_ends_at->isFuture();

        $subscriptionActive = $restaurant->subscription_status === 'active'
            && $restaurant->subscription_expires_at
            && $restaurant->subscription_expires_at->isFuture();

        if (!$restaurant->is_active || (!$trialActive && !$subscriptionActive)) {
            return view('public.unavailable', compact('restaurant'));
        }

        $categories = Category::where('restaurant_id', $restaurant->_id)->orderBy('order')->get();
        $items = Item::where('restaurant_id', $restaurant->_id)
            ->where('is_available', true)
            ->get()
            ->groupBy(fn($item) => (string) $item->category_id);

        $trendingItems = $trending->getTrendingItems((string) $restaurant->_id);

        return view('public.menu', compact('restaurant', 'categories', 'items', 'trendingItems'));
    }

    public function trackView(Request $request, $slug, $itemId)
    {
        $restaurant = Restaurant::where('slug', $slug)->firstOrFail();
        $item = Item::where('_id', $itemId)->where('restaurant_id', $restaurant->_id)->firstOrFail();

        AnalyticsEvent::create([
            'restaurant_id' => $restaurant->_id,
            'item_id'       => $item->_id,
            'session_id'    => $request->session()->getId(),
            'event_type'    => 'view',
        ]);

        $item->increment('view_count');

        return response()->json(['status' => 'ok']);
    }

    public function notifyWaiter(Request $request, $slug, $itemId)
    {
        $restaurant = Restaurant::where('slug', $slug)->firstOrFail();
        $item = Item::where('_id', $itemId)->where('restaurant_id', $restaurant->_id)->firstOrFail();
        $tableNumber = $request->query('table');

        TableRequest::create([
            'restaurant_id' => $restaurant->_id,
            'item_id' => $item->_id,
            'table_number' => $tableNumber,
            'status' => 'pending',
            'session_id' => $request->session()->getId(),
        ]);

        // This also strengthens Algorithm 1 (Trending) — order-intent is now a real signal,
        // weighted 2x higher than a plain view in TrendingService's scoring formula.
        AnalyticsEvent::create([
            'restaurant_id' => $restaurant->_id,
            'item_id' => $item->_id,
            'session_id' => $request->session()->getId(),
            'event_type' => 'order',
        ]);
        $item->increment('order_count');

        return response()->json(['status' => 'ok']);
    }
}