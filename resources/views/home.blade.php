<html>
  <head>
    <title>QVO | Ejemplos Laravel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.css">
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
  </head>
  <body>
    <div class="index-content">
      <h1 class="background-title">Ejemplos</h1>
      <div class="example-selector">
        <div class="example-option">
          <h3 class="title">Cobrar a tarjeta</h3>
          <p class="lead">Realiza un cobro puntual mediante Webpay Plus.</p>
          <a class="btn btn-primary" href="/charge">Ver ejemplo</a>
        </div>
        <div class="example-option">
          <h3 class="title">Planes y suscripciones</h3>
          <p class="lead">Crea planes de suscripción y recibe pagos automáticos con tarjetas de crédito.</p>
          <a class="btn btn-primary" href="/subscriptions">Ver ejemplo</a>
        </div>
        <div class="example-option">
          <h3 class="title">Botón de pago y Checkout</h3>
          <p class="lead">Brinda a tus usuarios una experiencia en constante mejora, optimizada y lista para dispositivos móviles.</p>
          <a class="btn btn-primary" href="/checkout">Ver ejemplo</a>
        </div>
      </div>
    </div>
  </body>
</html>
