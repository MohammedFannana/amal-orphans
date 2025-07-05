<?php

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;


class MessageController extends Controller
{
    public function view(){

        $sponsor = auth('sponsor')->user()->id;
        $messages =DatabaseNotification::where('notifiable_type' , 'App\Models\Sponsor')
        ->where('notifiable_id' , $sponsor)
        ->where('status' , 'active')
        ->where('type' , 'App\Notifications\OrphanMessage')
        ->where('created_at', '>=',now()->subDays(8))
        ->paginate(8);

        $this->makeReadNotification(auth('sponsor')->user() ,$messages);


        return view('Sponsers.message' , compact('messages'));

    }

    public function AdminviewMessage(){

        $messages =DatabaseNotification::where(function ($query) {
            $query->where('notifiable_type', 'App\Models\Sponsor')
                ->orWhere('notifiable_type', 'App\Models\User');
        })
        ->where('status' , 'active')
        ->where('type' , 'App\Notifications\OrphanMessage')
        ->where('created_at', '>=',now()->subDays(8))
        ->paginate(8);

        $this->makeReadNotification(auth('web')->user() , $messages);

        return view('Sponsers.message' , compact('messages'));

    }

    protected function makeReadNotification($user , $messages){
        $notifications = $user->unreadNotifications;
        $notifications->markAsRead();
        foreach($messages as $message){
            $message->update([
                'read_at' => now(),
            ]);
        }

        return;
    }




}
