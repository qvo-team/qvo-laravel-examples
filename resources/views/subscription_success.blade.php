@extends('examples_layout')

@section('sidebar')
  <span class="page-title">Ejemplo: <strong>Suscripción</strong></span>
@stop
@section('content')
  <h1>Éxito! 🤓</h1>
  <p>
    Felicitaciones {{ $response->customer->name }}, estás suscrito a {{ $response->plan->name }} 🙂.
  </p>
  <h2>Detalles del plan</h2>
  <p>
    <strong>Plan:</strong> {{ $response->plan->name }}
  </p>
  <p>
    <strong>Precio:</strong>
    {{ $response->plan->currency}} {{ $response->plan->price }} /{{ $response->plan->interval }}
  </p>
  <h2>Detalles de la transacción</h2>
  <p>
    <strong>Monto:</strong>
    {{ $response->transactions[0]->amount }}
  </p>

  <p>
    <strong>Moneda:</strong>
    {{ $response->plan->currency }}
  </p>
  <p>
    <strong>Fecha:</strong>
    {{ $response->created_at }}
  </p>
  <p>
    <strong>Descripción:</strong>
    {{ $response->transactions[0]->description }}
  </p>
  <a class="btn btn-primary" href="/">Volver al Inicio</a>
  <a class="btn btn-primary" href="/subscription">Volver al Ejemplo</a>
  <hr>
  <p>Respuesta de la API:</p>
  <pre data-src="prism.js" class='language-javascript'>
<code>
{{ json_encode($response, JSON_PRETTY_PRINT) }}
</code>
  </pre>
@stop
