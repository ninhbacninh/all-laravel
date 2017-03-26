<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;
use Stripe\Stripe;
use Stripe\Charge;
use App\Order;
use Auth;
use Session;

class CartController extends Controller
{
    public function index()
    {
    	return view('cart');
    }

    public function store(Request $request)
    {
    	$duplicates = Cart::search(function ($cartItem, $rowId) use ($request) {
    		return $cartItem->id === $request->id;
    	});

    	if(!$duplicates->isEmpty()) {
    		return redirect('cart')->with('success', 'Item is already in your cart!');
    	}

    	Cart::add($request->id, $request->name, 1, $request->price)->associate('App\Product');

    	return redirect('cart')->with('success', 'Item was added to your cart!');
    }

    public function update(Request $request, $id)
    {
    	Cart::update($id, $request->qty);
    	return back()->with('success', 'Item was updated successfully!');
    }

    public function destroy($id)
    {
    	Cart::remove($id);
    	return back()->with('success', 'Deleted item successfully');
    }

    public function emptyCart()
    {
    	Cart::destroy();
    	return back()->with('success', 'Deleted all items successfully');
    }

    public function getStripe()
    {
    	$total = Cart::total();
        return view('checkout.stripe', compact('total'));
    }

    public function postStripe(Request $request)
    {
    	Stripe::setApiKey('sk_test_PkLXoCcgINs6jCC5FFXdSrAl');
        $total = Cart::total();
        $product_id = [];
        foreach(Cart::content() as $item) {
        	$product_id[] = $item->id;
        }

        //return $product_id;

        //dd($product_id);

    	try {
    		Charge::create([
               "amount" =>  $total * 100,
               "currency" => "usd",
               "source" => $request->input('stripeToken'),
               'description'=> "Test Stripe Api"
    		]);
            
            $order = new Order();
    		$order->name = $request->input('name');
    		$order->address = $request->input('address');
    		$order->phone = $request->input('phone');
    		$order->status = 1;
    		$order->user_id = Auth::user()->id;

    		$order->save();
    		//dd($order);

    		$order->products()->attach($product_id);

    	} catch(\Exception $e) {
            return redirect()->route('getStripe')->with('error', $e->getMessage());
    	}

    	Session::forget('cart');
    	return redirect('/shop')->with('success', 'Successfully purchased products!');   
    }
}
