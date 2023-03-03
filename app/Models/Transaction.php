<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction
{
    use HasFactory;
    protected $table = 'transaction';
    protected $fillable = [
        'total',
        'category_id',
        'note',
        'time',
        'location',
        'my_friend',
    ];

}
