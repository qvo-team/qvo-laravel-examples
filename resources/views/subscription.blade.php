@extends('examples_layout')

@section('sidebar')
  <span class="page-title">Ejemplo: <strong>Planes y suscripciones</strong></span>
@stop
@section('content')
  <form method="POST" action="subscription/init">
    {{ csrf_field() }}
    <h1>1. Ingresa tus datos:</h1>
    <div class="form-group">
      <label class="desc">Nombre:</label>
      <div class="form-control"><input name="name" type="text" value="" placeholder="Ingresa tu nombre" required=""></div>
    </div>
    <div class="form-group">
      <label class="desc">Email:</label>
      <div class="form-control"><input name="email" type="email" value="" placeholder="Ingresa tu email" required=""></div>
    </div>
    <div class="form-group">
      <label class="desc">Teléfono:</label>
      <div class="form-control"><input name="phone" type="tel" value="" placeholder="Ingresa tu teléfono (Opcional)"></div>
    </div>
    <h1>2. Elige tu plan:</h1>
    <div class="plans">
      @foreach ($plans as $plan)
        <div class="plan">
          <div class="plan-content">
            <h1 class="plan-price">
              <span class="currency">{{ $plan->currency }}</span>
              {{ $plan->price }}
              <span class="interval">/mes</span>
            </h1>
            <p class="plan-name">{{ $plan->name }}</p>
          </div>
          <button class="btn btn-primary" name="qvo_plan_id" type="submit" value="{{ $plan->id }}">Inscribirse</button>
        </div>
      @endforeach
    </div>
  </form>

@stop