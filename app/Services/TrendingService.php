<?php

namespace App\Services;

use App\Models\AnalyticsEvent;
use App\Models\Item;
use Carbon\Carbon;

class TrendingService
{
    // After this many hours, an event's weight is cut in half
    protected float $halfLifeHours = 48;

    // Only consider events from this recent window (keeps the query cheap)
    protected int $lookbackDays = 14;

    public function getTrendingItems(string $restaurantId, int $limit = 5)
    {
        $events = AnalyticsEvent::where('restaurant_id', $restaurantId)
            ->where('created_at', '>=', Carbon::now()->subDays($this->lookbackDays))
            ->get();

        $now = Carbon::now();
        $scores = [];

        foreach ($events as $event) {
            $itemId = (string) $event->item_id;
            $ageHours = $now->diffInHours($event->created_at);
            $weight = $event->event_type === 'order' ? 2 : 1;
            $decay = $weight * pow(0.5, $ageHours / $this->halfLifeHours);

            $scores[$itemId] = ($scores[$itemId] ?? 0) + $decay;
        }

        arsort($scores);
        $topIds = array_slice(array_keys($scores), 0, $limit);

        if (empty($topIds)) {
            return collect();
        }

        $items = Item::whereIn('_id', $topIds)->where('is_available', true)->get();

        // Re-order to match score ranking (whereIn doesn't preserve order)
        return collect($topIds)
            ->map(fn($id) => $items->firstWhere(fn($i) => (string) $i->_id === $id))
            ->filter()
            ->values();
    }
}