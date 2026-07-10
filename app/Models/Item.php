<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Item extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'items';

    protected $fillable = [
        'restaurant_id', 'category_id', 'name', 'description',
        'price', 'old_price', 'photo', 'tags', 'is_available',
        'view_count', 'order_count', 'pricing_rules',
    ];

    protected $casts = [
        'tags' => 'array',
        'pricing_rules' => 'array',
        'price' => 'float',
        'old_price' => 'float',
        'is_available' => 'boolean',
    ];

    protected $attributes = [
        'view_count' => 0,
        'order_count' => 0,
        'tags' => '[]',
        'pricing_rules' => '[]',
    ];
}