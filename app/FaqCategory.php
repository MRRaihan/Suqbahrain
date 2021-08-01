<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{
    protected $fillable = ['faq_category_name'];

    public function faq()
    {
        return $this->hasMany(Faq::class);
    }
}
