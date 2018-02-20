<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use GuzzleHttp\Client; // Instalado con composer, ver composer.json

class SubscriptionController extends Controller
{
  private const QVO_API_URL = 'https://playground.qvo.cl'; // Reemplazar por https://api.qvo.cl en producción
  private const QVO_API_TOKEN = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJjb21tZXJjZV9pZCI6ImNvbV9xdFM0Z3JvbV9BZk5oQXo2REFvMnl3IiwiYXBpX3Rva2VuIjp0cnVlfQ.sM047UoHi52rXNmE7nJModcudpZ1GoZ_71FV2oVpCxU
QVO_PUBLIC_KEY=FkZcGOAppvKR6CCVvZI6jQ'; // Reemplazar por el token de producción cuando quieras pasar a producción

  public function subscription()
  {
    return view('subscription', ['plans' => $this->qvoPlans()]);
  }


  private function qvoPlans()
  {
    $guzzleClient = new Client();

    $plans_url = self::QVO_API_URL.'/plans';
    $body = $guzzleClient->request('GET', $plans_url, [
      'headers' => [
        'Authorization' => 'Bearer '.self::QVO_API_TOKEN
      ]
    ])->getBody();

    return json_decode($body);
  }

  public function init(Request $request)
  {
    $qvoCreateCustomerResponse = $this->createQVOCustomer($request->input('name'), $request->input('email'), $request->input('phone'));

    if(isset($qvoCreateCustomerResponse->error)) {
      $errorMessage = $qvoCreateCustomerResponse->error->message;
      return view('subscription', ['plans' => $this->qvoPlans(), 'notice' => $errorMessage]);
    }
    else {
      $qvoInitCardInscriptionResponse = $this->initCardInscription($qvoCreateCustomerResponse->id, $request->input('qvo_plan_id'));
      $cardInscriptionURL = $qvoInitCardInscriptionResponse->redirect_url;

      return Redirect::away($cardInscriptionURL);
    }
  }

  private function createQVOCustomer($name, $email, $phone)
  {
    $guzzleClient = new Client();
    $createCustomerURL = self::QVO_API_URL.'/customers';

    $body = $guzzleClient->request('POST',
      $createCustomerURL, [
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

  private function initCardInscription($qvoCustomerID, $qvoPlanID)
  {
    $guzzleClient = new Client();
    $initCardInscriptionURL = self::QVO_API_URL.'/customers/'.$qvoCustomerID.'/cards/inscriptions';
    $returnURL = "http://localhost:8000/subscription/card_inscription_return?qvo_plan_id=".$qvoPlanID."&qvo_customer_id=".$qvoCustomerID;

    $body = $guzzleClient->request('POST', $initCardInscriptionURL, [
      'json' => [
        'return_url' => $returnURL,
      ],
      'headers' => [
        'Authorization' => 'Bearer '.self::QVO_API_TOKEN
      ]
    ])->getBody();

    return json_decode($body);
  }

  public function cardInscriptionReturn(Request $request)
  {
    $uid = $request['uid'];
    $qvoCustomerID = $request['qvo_customer_id'];
    $qvoPlanID = $request['qvo_plan_id'];

    $cardInscriptionResponse = $this->checkCardInscription($qvoCustomerID, $uid);

    if($cardInscriptionResponse->status == 'succeeded'){
      $subscriptionResponse = $this->subscribeCustomerToPlan($qvoCustomerID, $qvoPlanID);
      return redirect('subscription/success/'.$subscriptionResponse->id);
    }
    else {
      $errorMessage = $cardInscriptionResponse->error;
      return view('subscription', ['plans' => $this->qvoPlans(), 'notice' => $errorMessage]);
    }
  }

  function checkCardInscription($qvoCustomerID, $uid)
  {
    $guzzleClient = new Client();
    $check_card_inscription_url = self::QVO_API_URL."/customers/".$qvoCustomerID."/cards/inscriptions/".$uid;

    $body = $guzzleClient->request('GET', $check_card_inscription_url, [
      'headers' => [
        'Authorization' => 'Bearer '.self::QVO_API_TOKEN
      ]
    ])->getBody();

    return json_decode($body);
  }

  function subscribeCustomerToPlan($qvoCustomerID, $qvoPlanID)
  {
    $guzzleClient = new Client();

    $subscribeURL = self::QVO_API_URL.'/subscriptions';
    $body = $guzzleClient->request('POST', $subscribeURL, [
      'json' => [
        'customer_id' => $qvoCustomerID,
        'plan_id' => $qvoPlanID
      ],
      'headers' => [
        'Authorization' => 'Bearer '.self::QVO_API_TOKEN
      ]
    ])->getBody();

    return json_decode($body);
  }

  function success(Request $request)
  {
    $subscriptionID = (string)$request['subscription_id'];
    $guzzleClient = new Client();
    $subscriptionURL = self::QVO_API_URL.'/subscriptions/'.$subscriptionID;

    $body = $guzzleClient->request('GET', $subscriptionURL, [
      'headers' => [
        'Authorization' => 'Bearer '.self::QVO_API_TOKEN
      ]
    ])->getBody();

    $response = json_decode($body);

    return view('success', ['response' => $response]);
  }
}

