<html>
  <head>
    <title>QVO | Ejemplos Laravel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Un poco de estilo para nuestros ejemplos -->
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/prism.css') }}">
    <script src="{{ URL::asset('js/prism.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.css">
  </head>
  <body>
    <nav>
      <a class="go-back" href="/">&lt; Volver al Inicio</a>
      @section('sidebar')
        <span class="page-title"><strong>Ejemplos</strong></span>
      @show
    </nav>
    <div class='content'>
      @if (isset($notice))
        <div class="alert alert-danger"><strong>Error: </strong>{{ $notice }}</div>
      @endif
      @yield('content')
    </div>
  </body>
</html>