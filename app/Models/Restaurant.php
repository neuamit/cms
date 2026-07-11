<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Restaurant extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'restaurants';

    protected $fillable = [
        'name', 'slug', 'address', 'phone', 'logo', 'cover_image',
        'wifi_password', 'owner_id', 'is_active', 'opening_hours',
        'facebook_url', 'instagram_url', 'tripadvisor_url',
        'trial_claimed', 'trial_ends_at', 'subscription_status',
        'subscription_plan', 'subscription_expires_at',
    ];

    protected $casts = [
        'trial_ends_at' => 'datetime',
        'subscription_expires_at' => 'datetime',
        'trial_claimed' => 'boolean',
    ];
}