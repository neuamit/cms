<?php

namespace App\Http\Controllers;

use App\Models\AnalyticsEvent;
use App\Models\Category;
use App\Models\Item;
use App\Models\Restaurant;
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

    if (!$restaurant->is_active) {
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

        // Log the raw event (feeds Trending + Recommendation algorithms later)
        AnalyticsEvent::create([
            'restaurant_id' => $restaurant->_id,
            'item_id'       => $item->_id,
            'session_id'    => $request->session()->getId(),
            'event_type'    => 'view',
        ]);

        // Keep a running counter on the item itself for fast reads
        $item->increment('view_count');

        return response()->json(['status' => 'ok']);
    }
}