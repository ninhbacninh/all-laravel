@extends('layouts.app')

@section('content')
   <div class="container">
   	 <p><a href="{{ url('shop') }}">Home</a> / Cart</p>
        <h1>Your Cart</h1>

        <hr>

         @include('partials.flash')

        @if(sizeof(Cart::content()) > 0)
           <table class="table">
           	<thead>
           		<th>Name</th>
           		<th>Image</th>
           		<th>Quantity</th>
           		<th>Price</th>
           		<th>Action</th>
           	</thead>
           	<tbody>
           		@foreach(Cart::content() as $item)
                   <tr>
                      <td><a href="{{url('shop', [$item->model->slug])}}">{{$item->name}}</a></td>
                   	  <td class="table-image"><a href="{{url('shop', [$item->model->slug])}}"><img src="{{url('img/'.$item->model->image)}}" alt="product" class="img-responsive cart-image" width="100px" height="70px"></a></td>
                      <td>
                        <form action="{{route('cart.update', ['rowId' => $item->rowId])}}" method="POST">
                           {{csrf_field()}}
                           {{method_field('PATCH')}}
                   	       <input type="text" name="qty" value="{{$item->qty}}" style="width:30%">
                   	       <input type="submit" class="btn btn-danger btn-sm" value="Update">
                        </form>
                      </td>
                   	  <td>$ {{$item->subtotal()}}</td>
                   	  <td>
                   	  	<form action="{{route('cart.destroy', ['rowId' => $item->rowId])}}" method="POST" class="side-by-side">
                   	  		{{csrf_field()}}
                   	  		{{method_field('DELETE')}}
                   	  		 <input type="submit" class="btn btn-danger btn-sm" value="Remove">
                   	  	</form>

                   	  	<form action="" method="POST" class="side-by-side">
                                {!! csrf_field() !!}
                                <input type="submit" class="btn btn-success btn-sm" value="To Wishlist">
                            </form>
                   	  </td>
                   </tr>
           		@endforeach
           		   <tr>
           		   	    <td class="table-image"></td>
           		   	 	<td></td>
           		   	 	<td class="small-caps table-bg" style="text-align: right">Subtotal</td>
           		   	 	<td>$ {{ Cart::instance('default')->subtotal() }}</td>
           		   	 	<td></td>
           		   	 	<td></td>          		   
           		   </tr>
           		   <tr>
           		   	    <td class="table-image"></td>
           		   	 	<td></td>
           		   	 	<td class="small-caps table-bg" style="text-align: right">Tax</td>
           		   	 	<td>$ {{ Cart::instance('default')->tax() }}</td>
           		   	 	<td></td>
           		   	 	<td></td>          		   
           		   </tr>
           		   <tr>
           		   	   <td class="table-image"></td>
                        <td style="padding: 40px;"></td>
                        <td class="small-caps table-bg" style="text-align: right">Your Total</td>
                        <td class="table-bg">$ {{ Cart::total() }}</td>
                        <td class="column-spacer"></td>
                        <td></td>
           		   </tr>
           	</tbody>
           </table>

           <a href="{{url('shop')}}" class="btn btn-primary btn-lg">Continue Shopping</a>  &nbsp;
           <a href="{{url('/pay-method')}}" class="btn btn-success btn-lg">Proceed to Checkout</a>

           <div style="float: right">
           	<form action="{{url('emptycart')}}" method="POST">
           		{{csrf_field()}}
           		{{method_field('DELETE')}}
           		<input type="submit" class="btn btn-danger btn-lg" value="Empty Cart">
           	</form>
           </div>
        @else
            <h3>You have no items in your shopping cart</h3>
            <a href="{{ url('/shop') }}" class="btn btn-primary btn-lg">Continue Shopping</a>
        @endif
   </div>
@endsection()