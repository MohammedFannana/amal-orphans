<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExternalLink extends Model
{
    protected $fillable = ['token'];

    public function allowedIps()
    {
        return $this->hasMany(ExternalLinkIp::class);
    }
}
