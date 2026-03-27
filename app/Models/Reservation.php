<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Reservation extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'reservations';

    protected $fillable = [
        'book_id',
        'member_id',
        'status', // pending, approved, cancelled
        'request_date',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
