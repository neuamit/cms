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
    ];
}