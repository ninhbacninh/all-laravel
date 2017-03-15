<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*Route::get('/add', function() {
    return \App\User::find(3)->add_friend(2);
});

Route::get('accept', function() {
    return \App\User::find(2)->accept_friend(1);
});

Route::get('/friends', function() {
    return \App\User::find(1)->friends();
});

Route::get('/pending-friends', function() {
   return \App\User::find(3)->pending_friend_request();
});

Route::get('/ids', function() {
   return \App\User::find(3)->friends_id();
});

Route::get('/is', function() {
   return \App\User::find(3)->is_friends_with(1);
});

Route::get('/ch', function() {
   return \App\User::find(3)->has_pending_request_send_to(2);
});*/

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::group(['middleware' => 'auth'], function() {
	Route::get('/profile/{slug}', [
       'uses' => 'ProfileController@index',
       'as' => 'profile.index'
	]);

	Route::get('/profile/edit/profile', [
       'uses' => 'ProfileController@edit',
       'as' => 'profile.edit'
	]);

	Route::post('/profile/update/profile', [
       'uses' => 'ProfileController@update',
       'as' => 'profile.update'
	]);

	Route::get('/check-relationship-status/{id}', [
       'uses' => 'FriendshipController@check',
       'as' => 'check'
	]);

	Route::get('/add-friend/{id}', [
       'uses' => 'FriendshipController@add_friend',
       'as' => 'add_friend'
	]);

	Route::get('/accept-friend/{id}', [
       'uses' => 'FriendshipController@accept_friend',
       'as' => 'accept_friend'
	]);


});

