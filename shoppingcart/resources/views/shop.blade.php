@extends('layouts.app')

@section('content')
   <div class="container">
   	  @include('partials.flash')

   	  <div class="jumbotron text-center clearfix">
            <h2>Shopping Cart</h2>
            <p>An example Laravel App that demos the basic functionality of a typical e-commerce shopping cart.</p>
            <p>
                <a href="http://andremadarang.com/implementing-a-shopping-cart-in-laravel/" class="btn btn-primary btn-lg" target="_blank">Blog Post</a>
                <a href="https://github.com/drehimself/laravel-shopping-cart-example" class="btn btn-success btn-lg" target="_blank">GitHub Repo</a>
            </p>
        </div> <!-- end jumbotron -->

        @foreach($products->chunk(4) as $items)
            <div class="row">
            	@foreach($items as $product)
                   <div class="col-md-3">
                   	  <div class="thumbnail">
                   	  	<div class="caption text-center">
                   	  		<a href="{{url('/shop', ['slug' => $product->slug])}}"><img src="{{url('/img/'.$product->image)}}" alt="product" class="img-responsive"></a>
                   	  		<a href="{{url('/shop', ['slug' => $product->slug])}}"><h3>{{$product->name}}</h3>
                   	  		<p>{{$product->price}}</p></a>
                   	  		<form action="{{url('cart')}}" method="POST">
   	  			               {{csrf_field()}}
   	  			                <input type="hidden" name="id" value="{{ $product->id }}">
                                <input type="hidden" name="name" value="{{ $product->name }}">
                                <input type="hidden" name="price" value="{{ $product->price }}">
                                <button class="btn btn-success btn-log" type="submit">AddToCart</button>
   	  		                </form>
                   	  		<a href="{{url('/shop', ['slug' => $product->slug])}}" class="btn btn-info">Details</a>
                   	  	</div>
                   	  </div>
                   </div>
            	@endforeach
            </div>
        @endforeach

    </div> <!-- end container -->
   </div>
@endsection()