<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Fine extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'fines';

    protected $fillable = [
        'loan_id',
        'member_id',
        'amount',
        'reason',
        'status',
        'issued_at',
        'paid_at',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
