<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfitSetting extends Model
{
    // protected $table = 'profit_settings';
    protected $fillable = [
        'suqbahrain_comission',
        'bdo_comission',
        'distributor_comission',
        'marchant_comission',
        'start_date',
        'end_date'
    ];
}
