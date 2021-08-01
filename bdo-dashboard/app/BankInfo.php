<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankInfo extends Model
{
    protected $fillable = [
        'user_id',
        'ac_holder',
        'ac_no',
        'bank_name',
        'iban_number',
        'address',
        'routing_no',
        'status',
    ];


    /**
     * Get all of the withdraw for the BankInfo
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function withdraw()
    {
        return $this->hasMany(Withdraw::class, 'bank_info_id', 'id');
    }
}
