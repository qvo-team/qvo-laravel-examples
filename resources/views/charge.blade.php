@extends('examples_layout')

@section('sidebar')
  <span class="page-title">Ejemplo: <strong>Cobrar a trajeta</strong></span>
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
      <form method="POST" action="charge/pay">
        {{ csrf_field() }}
        <input type="hidden" name="amount" value="{{ $product['price'] }}"><button class="btn btn-primary" type="submit">
          Pagar ${{ $product['price'] }}
        </button>
      </form>
    </div>

  </div>

  <div class="credits">
    <span>
      Icons made by <a href="https://www.flaticon.com/authors/pixel-buddha" title="Pixel Buddha">Pixel Buddha</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a>
    </span>
  </div>
@stop
