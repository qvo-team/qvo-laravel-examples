<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use GuzzleHttp\Client; // Instalado con composer, ver composer.json

class SubscriptionController extends Controller
{
  const QVO_API_URL = 'https://playground.qvo.cl'; // Reemplazar por https://api.qvo.cl en producción
  const QVO_API_TOKEN = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJjb21tZXJjZV9pZCI6ImNvbV9xdFM0Z3JvbV9BZk5oQXo2REFvMnl3IiwiYXBpX3Rva2VuIjp0cnVlfQ.sM047UoHi52rXNmE7nJModcudpZ1GoZ_71FV2oVpCxU
QVO_PUBLIC_KEY=FkZcGOAppvKR6CCVvZI6jQ'; // Reemplazar por el token de producción cuando quieras pasar a producción

  function index()
  {
    return view('subscription', ['plans' => $this->qvoPlans()]);
  }


  function qvoPlans()
  {
    $guzzle_client = new Client();

    $plans_url = self::QVO_API_URL.'/plans';
    $body = $guzzle_client->request('GET', $plans_url, [
      'headers' => [
        'Authorization' => 'Bearer '.self::QVO_API_TOKEN
      ]
    ])->getBody();

    return json_decode($body);
  }

  function init(Request $request)
  {
    $qvo_create_customer_response = $this->createQVOCustomer($request->input('name'), $request->input('email'), $request->input('phone'));

    if($qvo_create_customer_response->error) {
      $error_message = $qvo_create_customer_response->error->message;
      return view('subscription', ['plans' => $this->qvoPlans(), 'notice' => $error_message]);
    }
    else {
      $qvo_init_card_inscription_response = $this->initCardInscription($qvo_create_customer_response->id, $request->input('qvo_plan_id'));
      $card_inscription_url = $qvo_init_card_inscription_response->redirect_url;

      return Redirect::away($card_inscription_url);
    }
  }

  function createQVOCustomer($name, $email, $phone)
  {
    $guzzle_client = new Client();
    $create_customer_url = self::QVO_API_URL.'/customers';

    $body = $guzzle_client->request('POST',
      $create_customer_url, [
        'json' => [
          'name' => $name,
          'email' => $email,
          'phone' => $phone
        ],
        'headers' => [
          'Authorization' => 'Bearer '.self::QVO_API_TOKEN
        ],
        'http_errors' => false
      ]
    )->getBody();

    return json_decode($body);
  }

  function initCardInscription($qvo_customer_id, $qvo_plan_id)
  {
    $guzzle_client = new Client();
    $init_card_inscription_url = self::QVO_API_URL.'/customers/'.$qvo_customer_id.'/cards/inscriptions';
    $return_url = "http://localhost:8000/subscription/card_inscription_return?qvo_plan_id=".$qvo_plan_id."&qvo_customer_id=".$qvo_customer_id;

    $body = $guzzle_client->request('POST', $init_card_inscription_url, [
      'json' => [
        'return_url' => $return_url,
      ],
      'headers' => [
        'Authorization' => 'Bearer '.self::QVO_API_TOKEN
      ]
    ])->getBody();

    return json_decode($body);
  }

  function cardInscriptionReturn(Request $request)
  {
    $uid = $request['uid'];
    $qvo_customer_id = $request['qvo_customer_id'];
    $qvo_plan_id = $request['qvo_plan_id'];

    $card_inscription_response = $this->check_card_inscription($qvo_customer_id, $uid);

    if($card_inscription_response->status == 'succeeded'){
      $subscription_response = $this->subscribe_customer_to_plan($qvo_customer_id, $qvo_plan_id);
      return response()->json($subscription_response);
    }
    else {
      return response()->json($card_inscription_response);
    }
  }

  function check_card_inscription($qvo_customer_id, $uid)
  {
    $guzzle_client = new Client();
    $check_card_inscription_url = self::QVO_API_URL."/customers/".$qvo_customer_id."/cards/inscriptions/".$uid;

    $body = $guzzle_client->request('GET', $check_card_inscription_url, [
      'headers' => [
        'Authorization' => 'Bearer '.self::QVO_API_TOKEN
      ]
    ])->getBody();

    return json_decode($body);
  }

  function subscribe_customer_to_plan($qvo_customer_id, $qvo_plan_id)
  {
    $guzzle_client = new Client();

    $subscribe_url = self::QVO_API_URL.'/subscriptions';
    $body = $guzzle_client->request('POST', $subscribe_url, [
      'json' => [
        'customer_id' => $qvo_customer_id,
        'plan_id' => $qvo_plan_id
      ],
      'headers' => [
        'Authorization' => 'Bearer '.self::QVO_API_TOKEN
      ]
    ])->getBody();

    return json_decode($body);
  }

  function success(Request $request)
  {
    $subscription_id = (string)$request['subscription_id'];
    $guzzle_client = new Client();
    $subscription_url = self::QVO_API_URL.'/subscriptions/'.$subscription_id;

    $body = $guzzle_client->request('GET', $subscription_url, [
      'headers' => [
        'Authorization' => 'Bearer '.self::QVO_API_TOKEN
      ]
    ])->getBody();

    $response = json_decode($body);

    return view('success', ['response' => $response]);
  }
}

