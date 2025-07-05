<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'orphan_id' , 'duration' , 'bail_amount' , 'payment_received' ,
        'thank_letter_video' , 'thank_letter_audio' , 'delivery_bail' ,'status'
    ];

    public function orphan(){
        return $this->belongsTo(Orphan::class)->withDefault();
    }
}
