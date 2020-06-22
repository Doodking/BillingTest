<?php

use Illuminate\Support\Facades\Route;

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
    return view('register');
});

Route::apiResource('/register', 'BillingController');

Route::delete('/register', 'BillingController@destroy');

// Route::get('/register', 'BillingController@get');

// Route::post('/register', 'BillingController@register');

Route::get('/payment/paymentId={id}', 'DataController@getPayment');

Route::post('/payment/paymentId={id}', 'BillingController@pay');


