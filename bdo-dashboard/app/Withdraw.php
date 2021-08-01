<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    protected $fillable = [
        'user_id',
        'bank_info_id',
        'withdraw_amount',
        'deposit_club_point',
        'status',
        'agree_term',

    ];

    /**
     * Get the user that owns the withdraw
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bankinfo(){
        return $this->belongsTo(BankInfo::class, 'bank_info_id', 'id');
    }
}


