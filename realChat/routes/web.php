<?php



Auth::routes();

Route::get('/home', 'HomeController@index');

Route::post('/language-chooser', 'LanguageController@changeLanguage');

Route::post('/language', [
   'before' => 'csrf',
   'as' => 'language-chooser',
   'uses' => 'LanguageController@changeLanguage'
]);

Route::group(['middleware' => 'auth'], function() {
   Route::get('/', 'ChatController@index');
   Route::get('messages', 'ChatController@fetchMessages');
   Route::post('messages', 'ChatController@sendMessage');
});

