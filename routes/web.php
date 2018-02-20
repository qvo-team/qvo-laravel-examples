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
Route::view('/', 'home');

Route::get('/checkout', 'CheckoutController@checkout');
Route::get('/checkout/register_transaction/{transaction_id}', 'CheckoutController@registerTransaction');

Route::get('/subscription', 'SubscriptionController@subscription');
Route::post('/subscription/init', 'SubscriptionController@init');
Route::get('/subscription/card_inscription_return', 'SubscriptionController@cardInscriptionReturn');
Route::get('/subscription/success/{subscription_id}', 'SubscriptionController@success');

Route::get('/charge', 'ChargeController@charge');
Route::post('/charge/pay', 'ChargeController@pay');
Route::get('/charge/return_after_form', 'ChargeController@returnAfterForm');