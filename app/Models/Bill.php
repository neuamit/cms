<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Bill extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'bills';

    protected $fillable = [
        'restaurant_id', 'table_number', 'items', 'total', 'status',
    ];

    protected $casts = [
        'items' => 'array',
    ];
}