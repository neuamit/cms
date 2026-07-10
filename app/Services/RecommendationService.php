<?php

namespace App\Services;

use App\Models\AnalyticsEvent;
use App\Models\Item;

class RecommendationService
{
    public function getRecommendations(string $restaurantId, string $itemId, int $limit = 4)
    {
        // Step 1: find every session that viewed this item
        $sessionIds = AnalyticsEvent::where('restaurant_id', $restaurantId)
            ->where('item_id', $itemId)
            ->pluck('session_id')
            ->unique();

        if ($sessionIds->isEmpty()) {
            return $this->fallback($restaurantId, $itemId, $limit);
        }

        // Step 2: find all OTHER items viewed within those same sessions
        $coViewedEvents = AnalyticsEvent::where('restaurant_id', $restaurantId)
            ->whereIn('session_id', $sessionIds->all())
            ->where('item_id', '!=', $itemId)
            ->get();

        if ($coViewedEvents->isEmpty()) {
            return $this->fallback($restaurantId, $itemId, $limit);
        }

        // Step 3: count co-occurrence frequency per item
        $counts = [];
        foreach ($coViewedEvents as $event) {
            $id = (string) $event->item_id;
            $counts[$id] = ($counts[$id] ?? 0) + 1;
        }

        arsort($counts);
        $topIds = array_slice(array_keys($counts), 0, $limit);

        $items = Item::whereIn('_id', $topIds)->where('is_available', true)->get();

        return collect($topIds)
            ->map(fn($id) => $items->firstWhere(fn($i) => (string) $i->_id === $id))
            ->filter()
            ->values();
    }

    // If there's no co-occurrence data yet (new restaurant, low traffic),
    // fall back to other items in the same category so the section is never empty.
    protected function fallback(string $restaurantId, string $itemId, int $limit)
    {
        $item = Item::find($itemId);
        if (!$item) {
            return collect();
        }

        return Item::where('restaurant_id', $restaurantId)
            ->where('category_id', $item->category_id)
            ->where('_id', '!=', $itemId)
            ->where('is_available', true)
            ->limit($limit)
            ->get();
    }
}