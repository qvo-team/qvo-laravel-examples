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

Route::get('/checkout', 'CheckoutController@index');
Route::get('/subscription', 'SubscriptionController@index');
Route::post('/subscription/init', 'SubscriptionController@init');
Route::get('/subscription/card_inscription_return', 'SubscriptionController@card_inscription_return');
Route::get('/checkout/register_transaction/{transaction_id}', 'CheckoutController@register_transaction');
