<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use GuzzleHttp\Client;

class CheckoutController extends Controller {

  const PRODUCT = array(
    "id" => 2,
    "name" => "Zapatillas Clásicas",
    "price" => 45900,
    "rating" => 4,
    "offer" => false,
    "img_path" => 'images/shoe.png',
    "description" =>
      "Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium cumque asperiores illum, dolores totam nostrum eum ducimus facilis, fuga possimus, temporibus ipsa quia nobis consequuntur voluptas libero? Amet, nam magnam."
  );

  const QVO_API_URL = 'https://playground.qvo.cl'; //Change it to https://api.qvo.cl on production
  const QVO_API_TOKEN = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJjb21tZXJjZV9pZCI6ImNvbV9xdFM0Z3JvbV9BZk5oQXo2REFvMnl3IiwiYXBpX3Rva2VuIjp0cnVlfQ.sM047UoHi52rXNmE7nJModcudpZ1GoZ_71FV2oVpCxU
QVO_PUBLIC_KEY=FkZcGOAppvKR6CCVvZI6jQ';

  function show() {
    return view('checkout/show', ['product' => self::PRODUCT]);
  }

  function register_transaction($transaction_id) {
    $client = new Client(); //GuzzleHttp\Client

    $body = $client->request('GET', self::QVO_API_URL."/transactions/".$transaction_id, [
      'headers' => [
        'Authorization' => "Bearer ".self::QVO_API_TOKEN
      ]
    ])->getBody();

    $response = json_decode($body);

    if ($response->status == "successful")
      return response()->json(['status' => 'ok']);
    else
      return response()->json(['status' => 'fail']);
  }
}

