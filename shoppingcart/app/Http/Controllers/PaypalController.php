<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;
use Session;
use App\Order;
use Auth;
use URL;
use Config;
use Redirect;

use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;

class PaypalController extends Controller
{
	private $apiContext;

	public function __construct()
	{
        $paypal_conf = Config::get('paypal');
        $this->apiContext =  new ApiContext(
            new OAuthTokenCredential(
               $paypal_conf['client_id'],
               $paypal_conf['secret']
            )
        );
        $this->apiContext->setConfig($paypal_conf['settings']);
	}

	public function getCheckout()
	{
		$total = Cart::total();
		return view('checkout.paypal', compact('total'));
	}

	public function postPaypal(Request $request)
	{
		//dd($request->all());
		//dd($this->apiContext);
		$total = Cart::total();
		$shipping = 1.2;
        $tax = 0;
        $totalPrice = $total + $shipping + $tax;

		$product_id = [];
        foreach(Cart::content() as $item) {
        	$product_id[] = $item->id;
        }
		//dd($product_id);


		$payer = new Payer();
	    $payer->setPaymentMethod("paypal");

		$item_list = [];
		foreach(Cart::content() as $p) {
            $item = new Item();
            $item->setName($p->name)
                 ->setCurrency('USD')
                 ->setQuantity($p->qty)
                 ->setPrice($p->price);
            $item_list[] = $item;     
		}
		//dd($item_list);

		$itemList = new ItemList();
        $itemList->setItems($item_list);

	    $details = new Details();
	    $details->setShipping($shipping)
	    ->setTax($tax)
	    ->setSubtotal($total);

	    $amount = new Amount();
	    $amount->setCurrency("USD")
	    ->setTotal($totalPrice)
	    ->setDetails($details);

	    $transaction = new Transaction();
	    $transaction->setAmount($amount)
	    ->setItemList($itemList)
	    ->setDescription("Payment with paypal")
	    ->setInvoiceNumber(uniqid());

	    //$baseUrl = getBaseUrl();
	    $redirectUrls = new RedirectUrls();
	    $redirectUrls->setReturnUrl(URL::route('checkout.paypal'))
	    ->setCancelUrl(URL::route('checkout.paypal'));

	    $payment = new Payment();
	    $payment->setIntent("sale")
	    ->setPayer($payer)
	    ->setRedirectUrls($redirectUrls)
	    ->setTransactions(array($transaction));
	    //dd($payment);
	    //$request = clone $payment;
	    

	    try {
	    	$payment->create($this->apiContext);

	    	$order = new Order();
    		$order->name = $request->input('name');
    		$order->address = $request->input('address');
    		$order->phone = $request->input('phone');
    		$order->status = 1;
    		$order->user_id = Auth::user()->id;

    		$order->save();
    		//dd($order);

    		$order->products()->attach($product_id);

	    } catch (\PayPal\Exception\PayPalConnectionException $ex) {
	        /*if(\Config::get('app.debug')) {
	        	echo "Exception" . $ex->getMessage() . PHP_EOL;
	        	$err_data = json_decode($ex->getData(), true);
	        	exit;
	        } else {
	        	die('Some error occur, sory for inconvenient!');
	        }*/
	        return redirect('checkout-paypal')->with('error', 'Payment failed!');
	    }

	    foreach($payment->getLinks() as $link) {
	    	if($link->getRel() == 'approval_url') {
	    		$redirect_url = $link->getHref();
	    		break;
	    	}
	    }

	    Session::put('payment_id', $payment->getId());
        if(isset($redirect_url)) {
           return Redirect::away($redirect_url);
        }

        Session::forget('cart');
        return redirect()->route('shop.index')->with('error', 'Unknown error occurred!!');
	}

	public function getPaypal(Request $request)
	{
        $payment_id = Session::get('payment_id');
        Session::forget('payment_id');
        if(empty(Request::get('PayerID')) || empty(Request::get('token'))) {
            Session::put('error', 'Payment failed');
        }
        
        $payment = Payment::get($payment_id, $this->apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId(Request::get('PayerID'));

        try {
            $result = $payment->execute($execution, $this->apiContext);
           
            if($result->getState() === 'approved')
            {
                return redirect()->route('shop.index')->with('success', 'Payment Successfully');
            }
            
        } catch(Exception $e) {
        
            return redirect('checkout-paypal')->with('error', 'Payment failed!');
        }
	}

}
