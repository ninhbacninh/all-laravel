@extends('layouts.app')

@section('content')
   <div class="container">
   	  <div class="row">
   	  	 <div class="panel panel-success">
   	  	 	<div class="panel-heading">
   	  	 		<h3>You choose pay method</h3>
   	  	 	</div>
   	  	 	<div class="panel-body">
   	  	 		<a href="{{url('/checkout-paypal')}}" class="btn btn-primary btn-lg">Paypal</a>  &nbsp;
                <a href="{{url('/ckeckout/stripe')}}" class="btn btn-success btn-lg">Stripe</a>
   	  	 	</div>
   	  	 </div>
   	  </div>
   </div>
@endsection()