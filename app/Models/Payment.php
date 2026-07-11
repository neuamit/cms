<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Payment extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'payments';

    protected $fillable = [
        'restaurant_id', 'plan', 'amount', 'transaction_uuid',
        'status', 'esewa_ref_id', 'raw_response',
    ];
}