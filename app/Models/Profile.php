<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

    // protected $casts = [
    //     'brother_name' => 'array',
    //     'brother_gender' => 'array',
    //     'brother_age' => 'array',
    //     'brother_marital_status' => 'array',
    //     'brother_jop' => 'array',
    //     'brother_id_number' => 'array',
    // ];

    protected $fillable = [

        'orphan_id'  ,'guardian_id_number' ,'guardian_housing' ,'guardian_whats_phone' ,'guardian_first_phone' ,'guardian_secound_phone' ,'guardian_email'
        ,'health_status' ,'disease_type' ,'medical_report' ,'not_available_medical_report' ,'educational_status' ,'academic_stage' ,'educational_certificate' ,'not_available_educational_certificate' ,'account_number'
        ,'bank' ,'phone_number_linked_account' ,'wallet_number' ,'wallet_owner' ,'wallet_owner_id_number' ,'wallet_owner_id_number_image' ,'not_available_wallet_owner_id_number_image'
        ,'brother_name' ,'brother_gender' ,'brother_age' ,'brother_marital_status' , 'brother_jop' ,'brother_id_number' ,'average'
    ];



    // one to one relation with orphans table
    public function orphan(){
        return $this->belongsTo(Orphan::class);
    }



}

