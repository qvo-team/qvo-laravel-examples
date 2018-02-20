<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use GuzzleHttp\Client; // Instalado con composer, ver composer.json

class ChargeController extends Controller
{
  private const PRODUCT = array(
    "id" => 2,
    "name" => "Polera de Basquetball",
    "price" => 25990,
    "rating" => 4,
    "offer" => false,
    "img_path" => 'images/basketball-jersey.png',
    "description" =>
      "Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium cumque asperiores illum, dolores totam nostrum eum ducimus facilis, fuga possimus, temporibus ipsa quia nobis consequuntur voluptas libero? Amet, nam magnam."
  );

  private const QVO_API_URL = 'https://playground.qvo.cl'; //Change it to https://api.qvo.cl on production
  private const QVO_API_TOKEN = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJjb21tZXJjZV9pZCI6ImNvbV9xdFM0Z3JvbV9BZk5oQXo2REFvMnl3IiwiYXBpX3Rva2VuIjp0cnVlfQ.sM047UoHi52rXNmE7nJModcudpZ1GoZ_71FV2oVpCxU
QVO_PUBLIC_KEY=FkZcGOAppvKR6CCVvZI6jQ';

  public function charge()
  {
    return view('charge', ['product' => self::PRODUCT]);
  }

  public function pay(Request $request)
  {
    $amount = $request['amount'];
    $initTransactionResponse = $this->initTransaction($amount);

    return Redirect::away($initTransactionResponse->redirect_url);
  }

  private function initTransaction($amount)
  {
    $guzzleClient = new Client();
    $charge_url = self::QVO_API_URL."/webpay_plus/charge";

    $body = $guzzleClient->request('POST',
      $charge_url, [
        'json' => [
          'amount' => $amount,
          'return_url' => 'http://localhost:8000/charge/return_after_form'
        ],
        'headers' => [
          'Authorization' => 'Bearer '.self::QVO_API_TOKEN
        ],
        'http_errors' => false
      ]
    )->getBody();

    return json_decode($body);
  }
}