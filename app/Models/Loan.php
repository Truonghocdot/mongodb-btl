<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Loan extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'loans';

    protected $fillable = [
        'book_id',
        'member_id',
        'borrow_date',
        'due_date',
        'return_date',
        'status',
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
