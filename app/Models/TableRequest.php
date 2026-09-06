<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class TableRequest extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'table_requests';

    protected $fillable = [
        'restaurant_id', 'item_id', 'table_number', 'status', 'session_id',
    ];
}