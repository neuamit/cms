<?php

namespace App\Services;

use App\Models\Item;

class MenuSearchService
{
    public function search(string $restaurantId, string $query, int $limit = 10)
    {
        $query = strtolower(trim($query));
        if ($query === '') {
            return collect();
        }

        $items = Item::where('restaurant_id', $restaurantId)
            ->where('is_available', true)
            ->get();

        $scored = [];

        foreach ($items as $item) {
            $name = strtolower($item->name);
            $description = strtolower($item->description ?? '');

            // Fast path: direct substring match (name or description)
            if (str_contains($name, $query) || str_contains($description, $query)) {
                $scored[] = ['item' => $item, 'score' => 0];
                continue;
            }

            // Slow path: fuzzy match against each word in the item name
            $words = explode(' ', $name);
            $bestDistance = PHP_INT_MAX;

            foreach ($words as $word) {
                $distance = levenshtein($query, $word);
                $threshold = max(1, (int) floor(strlen($word) * 0.4));

                if ($distance <= $threshold && $distance < $bestDistance) {
                    $bestDistance = $distance;
                }
            }

            if ($bestDistance !== PHP_INT_MAX) {
                // Offset fuzzy matches above exact substring matches
                $scored[] = ['item' => $item, 'score' => 10 + $bestDistance];
            }
        }

        usort($scored, fn($a, $b) => $a['score'] <=> $b['score']);

        return collect($scored)->take($limit)->pluck('item');
    }
}