<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClubPointSetting extends Model
{
    protected $fillable = [
        'point_per_doller',
        'customer_point',
        'marchant_point',
        'distributor_point',
        'start_date',
        'end_date',
    ];
}
