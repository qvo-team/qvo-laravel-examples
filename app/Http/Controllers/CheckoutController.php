<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use GuzzleHttp\Client;

class CheckoutController extends Controller
{
  private const PRODUCT = array(
    "id" => 2,
    "name" => "Zapatillas Clásicas",
    "price" => 45900,
    "img_path" => 'images/shoe.png',
    "description" =>
      "Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium cumque asperiores illum, dolores totam nostrum eum ducimus facilis, fuga possimus, temporibus ipsa quia nobis consequuntur voluptas libero? Amet, nam magnam."
  );

  private const QVO_API_URL = 'https://playground.qvo.cl'; //Change it to https://api.qvo.cl on production
  private const QVO_API_TOKEN = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJjb21tZXJjZV9pZCI6ImNvbV9xdFM0Z3JvbV9BZk5oQXo2REFvMnl3IiwiYXBpX3Rva2VuIjp0cnVlfQ.sM047UoHi52rXNmE7nJModcudpZ1GoZ_71FV2oVpCxU
QVO_PUBLIC_KEY=FkZcGOAppvKR6CCVvZI6jQ';

  public function checkout()
  {
    return view('checkout', ['product' => self::PRODUCT]);
  }

  public function registerTransaction($transaction_id)
  {
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

