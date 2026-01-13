<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\AdminMessageNotification;
use App\Models\User;
use App\Models\Message;


class MessageController extends Controller
{
    
    public function store(Request $request)
    {
        $data = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'subject' => 'nullable|string|max:255',
            'body' => 'required|string',
        ]);

        $message = Message::create([
            'sender_id' => auth()->id(),  // admin id
            'receiver_id' => $data['receiver_id'],
            'subject' => $data['subject'],
            'body' => $data['body'],
        ]);
        
        $msg = [
            'sub' => $request->subject,
            'msg' =>$request->body
        ];
        // Send notification
        $user = User::find($request->receiver_id);
        $user->notify(
                new AdminMessageNotification(
                    'Message From Admin',
                    $msg
                )
            );

       
        session()->flash('success', "Message Sent");
        return back();
        
    }

    public function getMessage(Request $request){
        
         $users = User::all();
         return view('dashboard.pages.messages.create',compact('users'));
    }
    
}

