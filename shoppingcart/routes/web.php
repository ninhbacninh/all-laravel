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
    return view('shop');
});

Route::resource('shop', 'ProductController');

Route::resource('cart', 'CartController');

Route::get('/emptycart', 'CartController@emptyCart');

Route::get('pay-method', function() {
	return view('checkout.pay_method');
});

Route::group(['middleware' => 'auth'], function() {
	Route::get('/ckeckout/stripe', [
       'uses' => 'CartController@getStripe',
       'as' => 'getStripe'
	]);
    Route::post('/checkout/stripe', [
       'uses' => 'CartController@postStripe',
       'as' => 'postStripe'
    ]);

    Route::get('checkout-paypal', 'PaypalController@getCheckout');
    Route::get('checkout/paypal', [
       'uses' => 'PaypalController@getPaypal',
       'as' => 'checkout.paypal'
    ]);
    Route::post('checkout/paypal', [
       'uses' => 'PaypalController@postPaypal',
       'as' => 'checkout.paypalpost'
    ]);
});

Auth::routes();

Route::get('/home', 'HomeController@index');
