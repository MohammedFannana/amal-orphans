<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Association extends  Authenticatable

{

    use Notifiable;

    protected $fillable=[
        'name',
        'address',
        'responsible_person',
        'email',
        'fax',
        'license_number',
        'phone',
        'phone1',
        'phone2',
        'password'
    ];

    protected $hidden = [
        'password',
    ];

    // one to many
    public function researchers()
    {
        return $this->hasMany(Researcher::class);
    }

    // one to many
    public function orphans()
    {
        return $this->hasMany(Orphan::class);
    }
}
