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

Route::get('/', 'DataController@getRegister');

Route::apiResource('/register', 'BillingController');

Route::delete('/register', 'BillingController@destroy');


Route::get('/payment/paymentId={id}', 'DataController@getPayment');



