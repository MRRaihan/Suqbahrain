<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfitPointSettings extends Model
{
    protected $fillable = [
        'point_per_doller',
        'marchant_point',
        'distributor_point',
        'customer_point',
        'point_start',
        'point_end',
        'marchant_profit',
        'distributor_profit',
        'customer_profit',
        'bdo_profit',
        'profit_start',
        'profit_end',
    ];
}
