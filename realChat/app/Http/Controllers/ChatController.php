<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use Auth;
use App\Events\MessageSent;

class ChatController extends Controller
{
    public function index() 
    {
    	return view('chat');
    }

    public function fetchMessages()
    {
    	$messages = Message::with('user')->get();
    	return response()->json($messages);
    }

    public function sendMessage(Request $request)
    {
    	$user = Auth::user();
    	$message = $user->messages()->create([
           'message' => $request->input('message')
        ]);
        broadcast(new MessageSent($user, $message))->toOthers();

        return ['status' => 'Message Sent!'];
    }
}
