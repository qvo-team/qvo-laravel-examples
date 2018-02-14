<html>
  <head>
    <title>QVO | Ejemplos Laravel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.css">
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
  </head>
  <body>
    <nav>
      <a class="go-back" href="/">&lt; Volver al Inicio</a>
      @section('sidebar')
        <span class="page-title"><strong>Ejemplos</strong></span>
      @show
    </nav>
    @yield('content')
  </body>
</html>