@extends('layouts.app')

@section('content')
   <div class="container">
   	  <div class="col-lg-4">
   	  	<div class="panel panel-success">
   	  		<div class="panel-heading text-center">
   	  			{{ $users->name }}'s Profile'
   	  		</div>
   	  		<div class="panel-body text-center">
   	  			<img src="{{ url('avatar/default',$users->avatar) }}" width="150px" height="150px" style="border-radius: 50%" alt="">
   	  			<p>
                  {{ $users->profile->location }}      
               </p>
   	  			<p>
   	  				@if(Auth::user()->id == $users->id)
                      <a href="{{ route('profile.edit') }}" class="btn btn-lg btn-info">Update Info</a>
   	  				@endif
   	  			</p>
   	  		</div>
   	  	</div>
        
        @if(Auth::id() !== $users->id)
         <div class="panel panel-default">
            <div class="body" id="app">
               <friend :profile_user_id="{{ $users->id }}"></friend>
            </div>
         </div>
        @endif 

         <div class="panel panel-default">
            <div class="panel-heading text-center">About me</div>
            <div class="panel panel-body">
               {{ $users->profile->about }}
            </div>
         </div>
   	  </div>
   </div>
@endsection()