<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;

class FriendshipController extends Controller
{
    public function check($id)
    {
    	if(Auth::user()->is_friends_with($id) == 1) 
    	{
    		return ["status" => "friends"];
    	}

    	if(Auth::user()->has_pending_friend_request_from($id) == 1)
    	{
    		return ["status" => "pending"];
    	}

    	if(Auth::user()->has_pending_request_send_to($id) == 1)
    	{
    		return ["status" => "waiting"];
    	}

    	return ["status" => 0];
    }

    public function add_friend($id)
    {
    	$response = Auth::user()->add_friend($id);
    	User::find($id)->notify(new \App\Notifications\NewfriendRequest(Auth::user()));

    	return $response;
    }

    public function accept_friend($id)
    {
    	$response = Auth::user()->accept_friend($id);
    	User::find($id)->notify(new \App\Notifications\FriendRequestAccepted(Auth::user()));

    	return $response;
    }
}
