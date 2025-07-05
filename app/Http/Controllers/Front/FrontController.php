<?php

namespace App\Http\Controllers\Front;

use App\Models\Ad;
use App\Models\User;
use App\Models\Orphan;
use App\Models\Sponsor;
use App\Models\Question;
use App\Models\Sponsorship;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Notifications\ContactMailMessageNotification;
// use Symfony\Component\Mime\Part\Text\HtmlPart;


class FrontController extends Controller
{
    public function index(){
        $questions = Question::get()->take(5);
        $ads = Ad::all();
        $orphansCount = Orphan::count();
        $orphanSponsorCount = Orphan::where('role' , 'sponsored')->count();
        $sponsorsCount = Sponsor::count();
        $sponsorshipsCount = Sponsorship::count();
        return view('index' , compact(['questions' , 'ads','orphansCount' ,'sponsorsCount' ,'sponsorshipsCount' , 'orphanSponsorCount']));
    }

    public function showOrphanToSponsored(){
        $orphans = Orphan::where('role' , 'waiting')->paginate(8);
        return view('front.show-orphan-to-sponsorship' , compact('orphans'));
    }

    public function send(Request $request){

        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);


        $admin = User::first(); // أو role=admin
        $admin->notify(new ContactMailMessageNotification($validated));

        return back()->with('success', 'تم إرسال رسالتك بنجاح!');
    }

    public function aboutUs(){
        return view('front.about_us');
    }
}
