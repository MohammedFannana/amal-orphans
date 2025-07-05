<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'orphan_id' , 'name' , 'status', 'report'  ,'review_date' ,'review_number'
    ];

    // relationship with orphan
    public function orphan()
    {
        return $this->belongsTo(Orphan::class);
    }
}
