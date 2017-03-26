@extends('layouts.app')

@section('content')
   <div class="container">
   	  <p><a href="{{url('/shop')}}">Shop /{{$product->name}}</a></p>
   	  <h1>{{$product->name}}</h1>
   	  <hr>

   	  <div class="row">
   	  	<div class="col-md-4">
   	  		<img src="{{url('img/'.$product->image)}}"  alt="product" class="img-responsive">
   	  	</div>
   	  	<div class="col-md-8">
   	  		<h3>$ {{$product->price}}</h3>
   	  		<form action="{{url('cart')}}" method="POST">
   	  			{{csrf_field()}}
   	  			<input type="hidden" name="id" value="{{ $product->id }}">
                <input type="hidden" name="name" value="{{ $product->name }}">
                <input type="hidden" name="price" value="{{ $product->price }}">
                <button class="btn btn-success btn-log" type="submit">AddToCart</button>
   	  		</form>
   	  		<br/>

   	  		<form action="" method="POST">
   	  			{{csrf_field()}}
   	  			<input type="hidden" name="id" value="{{ $product->id }}">
                <input type="hidden" name="name" value="{{ $product->name }}">
                <input type="hidden" name="price" value="{{ $product->price }}">
                <button class="btn btn-success btn-log" type="submit">AddToWishList</button>
   	  		</form>
   	  		<br/>
   	  		<h3>{{$product->description}}</h3>
   	  	</div>
   	  </div>

   	  <div class="spacer"></div>
   	  <br/><br/>

   	  <div class="row">
   	  	<h3>You may also like...</h3>
   	  	@foreach($interested as $product)
           <div class="col-md-3">
           	<div class="thumbnail">
           		<div class="caption text-center">
           		    <a href="{{url('/shop', ['slug' => $product->slug])}}"><img src="{{url('/img/'.$product->image)}}" alt="product" class="img-responsive"></a>
           			<a href="{{url('shop', ['slug' => $product->slug])}}">{{$product->name}}</a>
           			<a href="{{url('shop', ['slug' => $product->slug])}}"><h3>{{$product->name}}</h3>
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
   </div>
@endsection()