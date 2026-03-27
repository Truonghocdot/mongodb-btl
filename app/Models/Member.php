<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Member extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'members';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'join_date',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
