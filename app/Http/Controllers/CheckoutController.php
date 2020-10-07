<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Freshwork\Transbank\WebpayNormal;
use Freshwork\Transbank\WebpayPatPass;
use Freshwork\Transbank\RedirectorHelper;
use Carbon\Carbon;
use App\Purchase;
use App\ProductPurchase;
use App\CartPurchase;
use App\CartProductPurchase;
use App\Payment;
use App\Post;
use App\PostProduct;
use App\WebpayResponse;
use App\User;
use Auth;
use JWTAuth;

class CheckoutController extends Controller
{

	function storeCart(Request $request){	

		$user = JWTAuth::parseToken()->toUser();
		CartPurchase::where("user_id", $user->id)->delete();
		CartProductPurchase::where("user_id", $user->id)->delete();
		$order = Carbon::now()->timestamp.uniqid();
		
		session_start();
		$_SESSION["client_id"] = $user->id;
		$_SESSION["order"] = $order;
			
		if($request->action == "make-purchase"){
			
			$cartPurchase = new CartPurchase;
			$cartPurchase->user_id = $user->id;
			$cartPurchase->price = $request->amountToPay;
			$cartPurchase->total = $request->total;
			$cartPurchase->payment_type = $request->paymentType;
			$cartPurchase->post_id = $request->post_id;
			$cartPurchase->has_delivery = $request->delivery;
			$cartPurchase->save();

			foreach($request->productPurchases as $productPurchase){

				$cartPurchaseProduct = new CartProductPurchase;
				$cartPurchaseProduct->post_product_id = $productPurchase["product"]["id"];
				$cartPurchaseProduct->amount = $productPurchase["amount"];
				$cartPurchaseProduct->cart_purchase_id = $cartPurchase->id;
				$cartPurchaseProduct->price = $productPurchase["price"];
				$cartPurchaseProduct->user_id = $user->id;
				$cartPurchaseProduct->save();

				
			}

			return response()->json(["success" => true]);

		}else{

			//session_start();
			
			$_SESSION["purchase_id"]=$request->purchase_id;
			$_SESSION["purchase_price"] = $request->amountToPay;

			return response()->json(["success" => true]);

		}

	}
    
    public function initTransaction(WebpayNormal $webpayNormal)
	{
		session_start();
		$user = JWTAuth::parseToken()->toUser();
        $cart = CartPurchase::where("user_id", $user->id)->first();

		$price = 0;
		if(isset($_SESSION["purchase_price"])){
			$price = $_SESSION["purchase_price"];
			
		}else{
			$price = $cart->price;
		}

		$order = $_SESSION["order"];
		
		$webpayNormal->addTransactionDetail(intval($price), $order);  
		$response = $webpayNormal->initTransaction(route('checkout.webpay.response'), route('checkout.webpay.finish'), null, 'TR_NORMAL_WS', null, null); 
		// Probablemente también quieras crear una orden o transacción en tu base de datos y guardar el token ahí.

		return RedirectorHelper::redirectHTML($response->url, $response->token);
    }
    
    public function response(WebpayPatPass $webpayPatPass)  
	{  
		$result = $webpayPatPass->getTransactionResult(); 
		session_start();
		
		$_SESSION["response"] = $result;//session()->put('response',$result);
		dump($result, $_SESSION["client_id"]);
		$webpayPatPass->acknowledgeTransaction();

		// Revisar si la transacción fue exitosa ($result->detailOutput->responseCode === 0) o fallida para guardar ese resultado en tu base de datos. 
		//return RedirectorHelper::redirectBackNormal($result->urlRedirection);
		return RedirectorHelper::redirectBackNormal($result->urlRedirection);  
	}

	public function finish()  
	{

		session_start();
		$response = $_SESSION["response"];

		if($response == null){

			$cartPurchase = CartPurchase::where("user_id", $_SESSION["user_id"])->first();
			
			$payment = new Payment;
			$payment->purchase_id = 0;
			$payment->user_id = $_SESSION["user_id"];
			$payment->transfer = $_SESSION["order"];
			$payment->bank_id = 0;
			if($_SESSION["purchase_id"] != null){
				$payment->amount_to_pay = $_SESSION["purchase_price"];
			}else{
				$payment->amount_to_pay = $cartPurchase->price;
			}
			
			$payment->state = "rechazado";
			$payment->save();

			return view("user.failedPayment");
        
        }

		if($response->detailOutput->responseCode == 0){ // si la respuesta de webpay es 0
			//dd($response->detailOutput->responseCode);

			if(isset($_SESSION["purchase_id"])){

				$purchase = Purchase::where("id", $_SESSION["purchase_id"])->first();
				$purchase->is_payment_complete = 1;
				$purchase->payment_completed_at = Carbon::now();
				$purchase->shipping_state = "en proceso";
				$purchase->update();

				$payment = new Payment;
				$payment->purchase_id = $purchase->id;
				$payment->user_id = $_SESSION["user_id"];
				$payment->transfer = $_SESSION["order"];
				$payment->bank_id = 0;
				$payment->amount_to_pay = $_SESSION["purchase_price"];
				$payment->state = "aprobado";
				$payment->save();
				
				$productPurchases = ProductPurchase::where("purchase_id", $purchase->id)->get();
				foreach($productPurchases as $productPurchase){

					$product = PostProduct::where("id", $productPurchase->post_product_id)->first();
					$total = $product->amount;
					$product->amount = $total - $productPurchase->amount;
					$product->update();

				}

				$buyer = User::where("id", $payment->user_id)->first();
				$messageBuyer = "Hola ".$buyer->name."! Has completado la compra de los los siguientes platos: ";
				$purchaseProduct = ProductPurchase::with("postProduct")->where("purchase_id", $purchase->id)->get();
				$to_email = $buyer->email;
				$to_name = $buyer->name;
				
				$data = ["messageMail" => $messageBuyer, "purchaseProducts" => $purchaseProduct, "messageTo" => "buyer", "purchaseId" => $purchase->id];
				//dd(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
				\Mail::send("emails.purchaseMail", $data, function($message) use ($to_name, $to_email) {

					$message->to($to_email, $to_name)->subject("¡Tu compra ha sido completada!");
					$message->from( env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));

				});

				$post = Post::where("id", $purchase->post_id)->first();
				$seller = User::where("id", $post->user_id)->first();
				$messageSeller = "Hola ".$seller->name."! El cliente ".$buyer->name." ha completado la compra de los siguientes platos: ";
				$to_email = $seller->email;
				$to_name = $seller->name;
				$data = ["messageMail" => $messageSeller, "purchaseProducts" => $productPurchases, "messageTo" => "seller", "purchaseId" => $purchase->id];

				\Mail::send("emails.purchaseMail", $data, function($message) use ($to_name, $to_email) {

					$message->to($to_email, $to_name)->subject("¡Tu venta ha sido completada!");
					$message->from( env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));

				});

				$messageAdmin = "Hola Admin! El usuario ".$buyer->name." ha completado una compra con el usuario ".$seller->name." de los siguientes platos: ";
				$to_email = env("ADMIN_MAIL");
				$to_name = "admin";
				$data = ["messageMail" => $messageAdmin, "purchaseProducts" => $productPurchases, "messageTo" => "admin", "purchaseId" => $purchase->id];

				\Mail::send("emails.purchaseMail", $data, function($message) use ($to_name, $to_email) {

					$message->to($to_email, $to_name)->subject("¡Un usuario ha completado una compra!");
					$message->from( env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));

				});

				$purchasedProducts = ProductPurchase::with("postProduct")->where("purchase_id",$purchase->id)->get();

				return view("user.successPayment", ["purchaseProducts" => $purchasedProducts]);

			}else{

				$cartPurchase = CartPurchase::where("user_id", $_SESSION["user_id"])->first();

				$purchase = new Purchase;
				$purchase->user_id = $_SESSION["user_id"];
				$purchase->price = $cartPurchase->price;
				if($cartPurchase->payment_type == "reservation"){
					$purchase->reservated_at = Carbon::now();
					$purchase->is_payment_complete = 0;
				}else{
					$purchase->reservated_at = Carbon::now();
					$purchase->payment_completed_at = Carbon::now();
					$purchase->is_payment_complete = 1;
				}
				$purchase->has_delivery = $cartPurchase->has_delivery;
				$purchase->payment_type = $cartPurchase->payment_type;
				$purchase->total = $cartPurchase->total;
				$purchase->post_id = $cartPurchase->post_id;
				$purchase->save();

				$productPurchases = CartProductPurchase::where("user_id", $_SESSION["user_id"])->get();

				foreach($productPurchases as $productPurchase){

					$purchaseProduct = new ProductPurchase;
					$purchaseProduct->post_product_id = $productPurchase->post_product_id;
					$purchaseProduct->amount = $productPurchase->amount;
					$purchaseProduct->price = $productPurchase->price;
					$purchaseProduct->purchase_id = $purchase->id;
					$purchaseProduct->save();

				}
				
				$payment = new Payment;
				$payment->purchase_id = $purchase->id;
				$payment->user_id = $_SESSION["user_id"];
				$payment->transfer = $_SESSION["order"];
				$payment->bank_id = 0;
				$payment->amount_to_pay = $cartPurchase->price;
				$payment->state = "aprobado";
				$payment->save();

				$mailPurchaseType = "";
				if($cartPurchase->payment_type == "reservation"){
					$mailPurchaseType = "reservación";
				}else{
					$mailPurchaseType = "compra";
				}

				$buyer = User::where("id", $payment->user_id)->first();
				$messageBuyer = "Hola ".$buyer->name."! Has realizado una ".$mailPurchaseType." de los siguientes platos: ";
				$purchaseProduct = ProductPurchase::with("postProduct")->where("purchase_id", $purchase->id)->get();
				$to_email = $buyer->email;
				$to_name = $buyer->name;
				
				$data = ["messageMail" => $messageBuyer, "purchaseProducts" => $purchaseProduct, "messageTo" => "buyer", "purchaseId" => $purchase->id];
				//dd(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
				\Mail::send("emails.purchaseMail", $data, function($message) use ($to_name, $to_email, $mailPurchaseType) {

					$message->to($to_email, $to_name)->subject("¡Tu ".$mailPurchaseType." se ha realizado con éxito!");
					$message->from( env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
	
				});

				$post = Post::where("id", $cartPurchase->post_id)->first();
				$seller = User::where("id", $post->user_id)->first();
				$messageSeller = "Hola ".$seller->name."! Has concretado una ".$mailPurchaseType." de los siguientes platos: ";
				$to_email = $seller->email;
				$to_name = $seller->name;
				$data = ["messageMail" => $messageSeller, "purchaseProducts" => $purchaseProduct, "messageTo" => "seller", "purchaseId" => $purchase->id];

				\Mail::send("emails.purchaseMail", $data, function($message) use ($to_name, $to_email, $mailPurchaseType) {

					$message->to($to_email, $to_name)->subject("¡Has concretado una ".$mailPurchaseType."!");
					$message->from( env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
	
				});

				$messageAdmin = "Hola Admin! El usuario ".$buyer->name." ha concretado una ".$mailPurchaseType." con el usuario ".$seller->name." de los siguientes platos: ";
				$to_email = env("ADMIN_MAIL");
				$to_name = "admin";
				$data = ["messageMail" => $messageAdmin, "purchaseProducts" => $purchaseProduct, "messageTo" => "admin", "purchaseId" => $purchase->id];

				\Mail::send("emails.purchaseMail", $data, function($message) use ($to_name, $to_email, $mailPurchaseType) {

					$message->to($to_email, $to_name)->subject("¡Un usuario ha realizado una ".$mailPurchaseType."!");
					$message->from( env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
	
				});

				$purchasedProducts = ProductPurchase::with("postProduct")->where("purchase_id",$purchase->id)->get();

				return view("user.successPayment", ["purchaseProducts" => $purchasedProducts]);

			}

		}else{

			$cartPurchase = CartPurchase::where("user_id", $_SESSION["user_id"])->first();

			$payment = new Payment;
			$payment->purchase_id = 0;
			$payment->user_id = $_SESSION["user_id"];
			$payment->transfer = $_SESSION["order"];
			$payment->bank_id = 0;
			$payment->amount_to_pay = $cartPurchase->price;
			$payment->state = "rechazado";
			$payment->save();

			return view("user.failedPayment");

		}

		
	}

}
