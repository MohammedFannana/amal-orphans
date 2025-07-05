<?php

namespace App\Http\Controllers\Association;

use Illuminate\Support\Str;
use App\Models\ExternalLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;



class AssociationController extends Controller
{
    // public function generateRegistrationLink($associationId)
    // {
    //     $encryptedId = Crypt::encrypt($associationId);

    //     // $url =  URL::signedRoute('orphan.create', ['token' => $encryptedId]);

    //     $token = Str::random(40);

    //     $link = ExternalLink::create([
    //         'token' => $token,
    //     ]);

    //     $url = url("/orphan/create/{$token}") . '?token=' . $encryptedId;


    //     return view('associations.orphans.insert' ,compact('url'));
    //     // يمكنك إرسال الرابط عبر البريد أو عرضه للجمعية
    //     // return $url;
    // }


}
