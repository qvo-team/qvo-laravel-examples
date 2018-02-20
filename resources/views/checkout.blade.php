@extends('examples_layout')

@section('sidebar')
  <span class="page-title">Ejemplo: <strong>Botón de pago y checkout</strong></span>
@stop
@section('content')
  <div class="product-display">
    <div class="product-img">
      <img src="{{ URL::asset($product['img_path']) }}">
    </div>
    <div class="product-information">
      <h2 class="product-name">{{ $product['name'] }}</h2>
      <div class="product-rating">★★★★</div>
      <div class="product-price">${{ $product['price'] }}</div>
      <p class="product-description">{{ $product['description'] }}</p>
      <div id="qvo-button-container"></div>
    </div>
  </div>

  <script src="https://cdn.qvo.cl/checkout.min.js"></script>
  <script>
    let public_key = 'FkZcGOAppvKR6CCVvZI6jQ';

    qvo.button.render({
      env:          'sandbox',
      keys:         { sandbox: public_key },
      amount:       "{{ $product['price'] }}",
      description:  "{{ $product['name'] }}",
      name:         'Tu Tienda',
      image:        "{{ URL::asset($product['img_path']) }}",

      onSuccess: function(transaction) {
        // We check and register the transaction on our backend
        fetch('/checkout/register_transaction/' + transaction.id, { method: 'GET' })
        .then(function (response) {
          return response.ok ? response.json() : Promise.reject(response);
        })
        .then(function(response) {
          if(response.status == 'ok') {
            // Here you can redirect the user, display another message or whatever you want!
            window.alert('Pago Completado 😁!');
          } else {
            window.alert('Pago Fallido 😮, intenta nuevamente.');
          }
        })
        .catch(function(response) {
          console.error(response);
          window.alert('Existió un error en la verificación de la transacción');
        });
      }
    }, '#qvo-button-container');
  </script>

  <div class="credits">
    <span>
      Icons made by <a href="https://www.flaticon.com/authors/pixel-buddha" title="Pixel Buddha">Pixel Buddha</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a>
    </span>
  </div>

@stop
