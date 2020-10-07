<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Freshwork\Transbank\WebpayNormal;
use Freshwork\Transbank\WebpayPatPass;
use Freshwork\Transbank\RedirectorHelper;
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

			Session::put("test", "test");

			return response()->json(["success" => true]);

		}else{

			//session_start();
			Session::put('purchase_id',$request->purchase_id);
			Session::put('purchase_price',$request->amountToPay);
			
			//$_SESSION["purchase_id"]=$request->purchase_id;
			//$_SESSION["purchase_price"] = $request->amountToPay;

			return response()->json(["success" => true]);

		}

	}
	
	public function initTransaction(WebpayNormal $webpayNormal)
	{
		
		$user = JWTAuth::parseToken()->toUser();
        $cart = CartPurchase::where("user_id", $user->id)->first();
		$order = Carbon::now()->timestamp.uniqid();

		$price = 0;
		if(Session::get("purchase_price") != null){
			$price = Session::get("purchase_price");
			
		}else{
			$price = $cart->price;
		}

		$webpayNormal->addTransactionDetail(intval($price) + 1, $order);  
		//$response = $webpayNormal->initTransaction(route('checkout.webpay.response'), route('checkout.webpay.finish'), null, 'TR_NORMAL_WS', null, null);
		$response = $webpayNormal->initTransaction(route('checkout.webpay.response'), route('checkout.webpay.finish')); 
		// Probablemente también quieras crear una orden o transacción en tu base de datos y guardar el token ahí.

		return RedirectorHelper::redirectHTML($response->url, $response->token);
    }
    
    public function response(WebpayPatPass $webpayPatPass)  
	{  
		$result = $webpayPatPass->getTransactionResult();  
		session(['response' => $result]);  

		$webpayPatPass->acknowledgeTransaction();

		// Revisar si la transacción fue exitosa ($result->detailOutput->responseCode === 0) o fallida para guardar ese resultado en tu base de datos. 
		//return RedirectorHelper::redirectBackNormal($result->urlRedirection);
		return RedirectorHelper::redirectBackNormal($result->urlRedirection);  
	}

	public function finish(Request $request)  
	{

		dd($_POST, session('response'));  
		// Acá buscar la transacción en tu base de datos y ver si fue exitosa o fallida, para mostrar el mensaje de gracias o de error según corresponda
	}


}
