@extends('examples_layout')

@section('sidebar')
  <span class="page-title">Ejemplo: <strong>Cobrar a trajeta</strong></span>
@stop
@section('content')
  <h1>Éxito! 🤓</h1>
  <p>Tu transacción se ha realizado exitosamente. Gracias por confiar en nosotros 🙂.</p>
  <h2>Detalles de la transacción</h2>
  <p>
    <strong>ID de la transacción: </strong>
    {{ $response->id }}
  </p>
  <p>
    <strong>Fecha de la transacción: </strong>
    {{ $response->created_at }}
  </p>
  <p>
    <strong>Monto: </strong>
    {{ $response->amount }}
  </p>
  <p>
    <strong>Tipo de pago: </strong> {{ $response->payment->payment_type }}
  </p>
  </p>
  <a class="btn btn-primary" href="/">Volver al Inicio</a>
  <a class="btn btn-primary" href="/charge">Volver al Ejemplo</a>
  <hr>
  <p>Respuesta de la API:</p>
  <pre>
<code class="language-javascript">
{{ json_encode($response, JSON_PRETTY_PRINT) }}
</code>
  </pre>
@stop