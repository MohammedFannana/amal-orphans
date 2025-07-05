<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    public function OrphanNotification(){
        $notifications = auth('orphan')->user()->notifications->filter(function ($notification) {
            return $notification->type === 'App\Notifications\SponsorshipEndingSoon'
                || $notification->type === 'App\Notifications\SponsorshipEnded';
        })->where('created_at', '>=',now()->subDays(8));
        $this->makeReadNotification(auth('orphan')->user());
        return view('notification' , compact('notifications'));

    }

    public function SponsorNotification(){

        $notifications = auth('sponsor')->user()->notifications->filter(function ($notification) {
            return $notification->type === 'App\Notifications\SponsorshipEndingSoon'
                || $notification->type === 'App\Notifications\SponsorshipEnded';
        })->where('created_at'  , '>=' , now()->subDays(8));
        $this->makeReadNotification(auth('sponsor')->user());
        return view('notification' , compact('notifications'));

    }

    public function AdminNotification(){
        // dd(auth('orphan')->user()->unreadNotifications);

        $notifications = auth('web')->user()->notifications->filter(function ($notification) {
            return $notification->type === 'App\Notifications\SponsorshipEndingSoon'
                || $notification->type === 'App\Notifications\SponsorshipEnded';
        })->where('created_at'  , '>=' , now()->subDays(8));
        $this->makeReadNotification(auth('web')->user());
        return view('notification' , compact('notifications'));

    }

    public function AssociationNotification(){
        $notifications = auth('association')->user()->notifications->filter(function ($notification) {
        return $notification->type === 'App\Notifications\SponsorshipEndingSoon'
            || $notification->type === 'App\Notifications\SponsorshipEnded';
        })->where('created_at'  , '>=' , now()->subDays(8));
        $this->makeReadNotification(auth('association')->user());
        return view('notification' , compact('notifications'));

    }

    protected function makeReadNotification($user){
        $notifications = $user->unreadNotifications;
        $notifications->markAsRead();
        return;
    }
}
