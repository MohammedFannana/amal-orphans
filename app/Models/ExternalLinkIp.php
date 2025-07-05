<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExternalLinkIp extends Model
{
    protected $fillable = ['external_link_id', 'ip', 'expires_at'];
    protected $dates = ['expires_at'];

    public function link()
    {
        return $this->belongsTo(ExternalLink::class);
    }
}
