<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Order extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'orders';

    protected $fillable = [
        'customer_id',
        'order_code',
        'item_name',
        'quantity',
        'total_amount',
        'status',
        'ordered_at',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
