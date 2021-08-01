<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = [
        'faq_category_id',
        'faq_question',
        'faq_answer',
    ];

    public function faq_category(){
        return $this->belongsTo(FaqCategory::class);
    }
}
