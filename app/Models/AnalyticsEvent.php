<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class AnalyticsEvent extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'analytics_events';

    protected $fillable = ['restaurant_id', 'item_id', 'session_id', 'event_type'];
}