<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gambler extends Model
{
    protected $fillable = [
        'name',
        'points',
    ];

    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }
}
