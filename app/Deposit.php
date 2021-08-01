<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $fillable = [
        'user_id',
        'order_id',
        'product_id',
        'deposit_amount',
        'deposit_club_point',
    ];
}
