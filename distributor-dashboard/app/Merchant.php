<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    protected $fillable = [
        'distributor_id',
        'name',
        'email',
        'phone',
        'password',
        'identification',
        'address',
        'code',
    ];
}
