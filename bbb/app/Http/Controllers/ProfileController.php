<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class ProfileController extends Controller
{
    public function index($slug)
    {
    	$users = User::where('slug', $slug)->first();
    	return view('profiles.profile', compact('users'));
    }

    public function edit()
    {
    	return view('profiles.edit')->with('info', Auth::user()->profile);
    }

    public function update(Request $request)
    {
    	$this->validate($request, [
           'location' => 'required',
           'about' => 'required|max:500',
    	]);

    	Auth::user()->profile()->update([
          'location' => $request->location,
          'about' => $request->about,
    	]);

    	if($request->hasFile('avatar')) {
    		$name = $request->avatar->getClientOriginalName();
    		Auth::user()->update([
                'avatar' => $name
    	    ]);

    	    $request->avatar->move(public_path('avatar/default'), $name);
    	}

    	return redirect()->back()->with('success', 'Update info successfully');
    }
}
