<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    protected $fillable = [
        'name',
        'earnings_to_home',
        'earnings_to_winner',
        'total',
        'additional_pot',
        'status',
        'data',

    ];

    protected $casts = [
        'data' => 'array',
    ];
}
