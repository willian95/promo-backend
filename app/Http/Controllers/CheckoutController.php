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
use App\PostProduct;
use App\WebpayResponse;
use Auth;
use JWTAuth;

class CheckoutController extends Controller
{
    
    function storeCart(Request $request){	

		$user = JWTAuth::parseToken()->toUser();
		CartPurchase::where("user_id", $user->id)->delete();
		CartProductPurchase::where("user_id", $user->id)->delete();
			
		if($request->action == "make-purchase"){
			
			$cartPurchase = new CartPurchase;
			$cartPurchase->user_id = $user->id;
			$cartPurchase->price = $request->amountToPay;
			$cartPurchase->total = $request->total;
			$cartPurchase->payment_type = $request->paymentType;
			$cartPurchase->post_id = $request->post_id;
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

			session_start();
			$_SESSION["purchase_id"]=$request->purchase_id;
			$_SESSION["purchase_price"] = $request->amountToPay;

			return response()->json(["success" => true]);

		}

    }

    public function initTransaction(WebpayNormal $webpayNormal, Request $request)
	{
		
		$user = JWTAuth::parseToken()->toUser();
        $cart = CartPurchase::where("user_id", $user->id)->first();
		$order = Carbon::now()->timestamp.uniqid();

		session_start();
		$_SESSION["user_id"]=$user->id;
		$_SESSION["order"]=$order;

	
		$webpayNormal->addTransactionDetail(intval($cart->price), $order);  
		$response = $webpayNormal->initTransaction(route('checkout.webpay.response'), route('checkout.webpay.finish')); 
		// Probablemente también quieras crear una orden o transacción en tu base de datos y guardar el token ahí.

		return RedirectorHelper::redirectHTML($response->url, $response->token);
    }
    
    public function response(WebpayPatPass $webpayPatPass)  
	{  
		
		$result = $webpayPatPass->getTransactionResult();      
	
		session_start();
		$_SESSION["response"]=$result;

		//dd($result, session('response'), session("user"));

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
			if(isset($_SESSION["purchase_id"])){
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

				return view("user.successPayment");

			}else{

				$cartPurchase = CartPurchase::where("user_id", $_SESSION["user_id"])->first();

				$purchase = new Purchase;
				$purchase->user_id = $_SESSION["user_id"];
				$purchase->price = $cartPurchase->price;
				if($cartPurchase->payment_type == "reservation"){
					$purchase->is_payment_complete = 0;
				}else{
					$purchase->is_payment_complete = 1;
				}
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

				return view("user.successPayment");

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
