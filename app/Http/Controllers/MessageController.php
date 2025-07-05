<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Notifications\OrphanMessage;
use Illuminate\Notifications\DatabaseNotification;
// use Illuminate\Support\Facades\Notification;

class MessageController extends Controller
{
    public function create(){
        return view('orphans.message');
    }

    public function amalSendMessage(Request $request){

        $request->validate([
            'message' => 'required|string',
        ]);


        // إرسال إشعار للمستخدم نفسه
        $admin = User::first();

        DatabaseNotification::create([
            'id' => Str::uuid(),
            'type' => OrphanMessage::class,  // يمكن استخدام كلاس الاشعار هنا
            'notifiable_type' => get_class($admin),   // أو $sponsor
            'notifiable_id' => $admin->id,            // أو $sponsor->id
            'data' => [
                'message' => $request->message,
                'orphan_name' => auth('orphan')->user()->name,

            ],
            'orphan_id' => auth('orphan')->user()->id,
            'status' => 'inactive',   // أو 'inactive'
        ]);

        // $admin->notify(new OrphanMessage($data));

        return redirect()->back()->with('success', 'تم إرسال رسالتك بنجاح.');

    }

    public function SponsorSendMessage(Request $request){


        $request->validate([
            'message' => 'required|string',
        ]);


        // dd(auth('orphan')->user());
        // إرسال إشعار للمستخدم نفسه
        $sponsor = auth('orphan')->user()->activeSponsorships->sponsor;
        // dd($sponsor);

        // $sponsor->notify(new OrphanMessage($data));
        DatabaseNotification::create([
            'id' => Str::uuid(),
            'type' => OrphanMessage::class,  // يمكن استخدام كلاس الاشعار هنا
            'notifiable_type' => get_class($sponsor),   // أو $sponsor
            'notifiable_id' => $sponsor->id,            // أو $sponsor->id
            'data' => [
                'message' => $request->message,
                'orphan_name' => auth('orphan')->user()->name,
            ],
            'orphan_id' => auth('orphan')->user()->id,
            'status' => 'inactive',   // أو 'inactive'
        ]);

        return redirect()->back()->with('success', 'تم إرسال رسالتك بنجاح.');

    }

    public function message(){

        $orphans = auth('association')->user()->orphans;
        $orphanIds = $orphans->pluck('id')->toArray();

        // dd(auth('association')->user()->id);

        $messages = DatabaseNotification::where(function ($query) {
                $query->where('notifiable_type', 'App\Models\Sponsor')
                    ->orWhere('notifiable_type', 'App\Models\User');
            })
            ->where('status', 'inactive')
            // ->where('notifiable_id', auth('association')->user()->id)
            ->whereIn('orphan_id', $orphanIds)
            ->where('type', 'App\Notifications\OrphanMessage')
            ->paginate(8);

        return view('associations.message', compact('messages'));

    }

    public function activeMessage(string $id){

        // dd($id);

        $message = DatabaseNotification::findOrFail($id);

        $message->update([
            'status' => 'active',
        ]);

        return redirect()->back()->with('success' , 'تم إرسال الرسالة إلى الكافل بنجاح');


    }

    public function deleteMessage(string $id){
        $message = DatabaseNotification::findOrFail($id);
        $message->delete();
        return redirect()->back()->with('success' , 'تم إلغاء الرسالة إلى الكافل بنجاح');


    }
}

