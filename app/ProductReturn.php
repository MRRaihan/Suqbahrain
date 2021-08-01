<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductReturn extends Model
{
    protected  $table = 'product_returns';

    protected $fillable = [
        'image',
        'user_id',
        'order_id',
        'reason',
        'image',
        'view',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'id', 'order_id');
    }
}
