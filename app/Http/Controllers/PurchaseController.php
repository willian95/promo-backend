<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Purchase;
use App\Payment;
use Carbon\Carbon;
use App\ProductPurchase;
use App\Post;
use JWTAuth;
use App\Http\Requests\PurchaseStoreRequest;
use Tymon\JWTAuth\Exceptions\JWTException;

class PurchaseController extends Controller
{
    function index(){
        return view("user.purchases.index");
    }

    function userFetch($page = 1){

        try{

            $skip = ($page-1) * 20;
            $user = JWTAuth::parseToken()->toUser();
            $purchases = Purchase::with("post", "post.user")->where("user_id", $user->id)->skip($skip)->take(20)->orderBy("id","desc")->get();
            $purchasesCount = Purchase::with("post", "post.user")->where("user_id", $user->id)->count();

            return response()->json(["success" => true, "purchases" => $purchases, "purchasesCount" => $purchasesCount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function showMyPurchaseInfo($id){

        try{

            $purchase = Purchase::where("id", $id)->with("post", "payments", "post.category", "user", "productsPurchase", "productsPurchase.postProduct")->first();
            $paymentsAmount = Payment::where("purchase_id", $id)->count();
            $paymentsAproved = Payment::where("purchase_id", $id)->where("state", "aprobado")->count();
            $paymentsWaiting = Payment::where("purchase_id", $id)->where("state", "en proceso")->count();
            //$payments = Payment::where("purchase_id", $id)->where("state", "en preceso")->count();
            return view("user.purchases.show", ["purchase" => $purchase, "todaysDate" => Carbon::now(), "paymentsAmount" => $paymentsAmount, "paymentsAproved" => $paymentsAproved, "paymentsWaiting" => $paymentsWaiting]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

    function confirmDelivery(Request $request){

        try{

            Purchase::where("id", $request->id)->update(["shipping_state" => "recibido"]);

            $post = Post::where("id", $purchase->post_id)->first();
            $seller = User::where("id", $post->user_id)->first();
            $buyer = User::where("id", $purchase->user_id)->first();
            $messageBuyer = "Hola ".$seller->name."! El cliente ".$buyer->name." indica sus platos fueron entregados";
            $to_email = $buyer->email;
            $to_name = $buyer->name;
            
            $data = ["messageMail" => $messageBuyer];
            \Mail::send("emails.confirmMail", $data, function($message) use ($to_name, $to_email) {

                $message->to($to_email, $to_name)->subject("¡Tus platos fueron recibidos!");
                $message->from( env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));

            });

            $messageBuyer = "Hola admin! El cliente ".$buyer->name." indica que el vendedor ".$buyer->name." ha entregado sus platos";
            $to_email = env("ADMIN_MAIL");
			$to_name = "admin";
            
            $data = ["messageMail" => $messageBuyer];
            \Mail::send("emails.confirmMail", $data, function($message) use ($to_name, $to_email) {

                $message->to($to_email, $to_name)->subject("¡Platos entregados!");
                $message->from( env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));

            });

            return response()->json(["success" => true, "msg" => "Ha confirmado la entrega del articulo, recuerde dejar su calificación al vendedor"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }
    
    function reserve(PurchaseStoreRequest $request){

        try{

            $user = JWTAuth::parseToken()->toUser();

            if($request->action == "make-purchase"){
                
                $purchase = new Purchase;
                $purchase->user_id = $user->id;
                $purchase->price = $request->amountToPay;
                $purchase->total = $request->total;
                $purchase->payment_type = $request->type;
                $purchase->post_id = $request->postId;
                $purchase->save();

                $payment = new Payment;
                $payment->purchase_id = $purchase->id;
                $payment->user_id = $user->id;
                $payment->transfer = $request->transfer;
                $payment->bank_id = $request->bank;
                $payment->amount_to_pay = $request->amountToPay;
                $payment->save();

                foreach($request->productsPurchase as $product){

                    $productPurchase = new ProductPurchase;
                    $productPurchase->purchase_id = $purchase->id;
                    $productPurchase->post_product_id = $product["product"]["id"];
                    $productPurchase->amount = $product["amount"]; 
                    $productPurchase->price = $product["price"];
                    $productPurchase->save();

                }



            }else{

                $payment = new Payment;
                $payment->purchase_id = $request->purchaseId;
                $payment->user_id = $user->id;
                $payment->transfer = $request->transfer;
                $payment->bank_id = $request->bank;
                $payment->amount_to_pay = $request->amountToPay;
                $payment->save();

            }

            if($request->action == "make-purchase"){
                return response()->json(["success" => true, "msg" => "Has realizado una reservación, le notificaremos cuando el pago haya sido aprobado"]);
            }else{
                return response()->json(["success" => true, "msg" => "Has terminado la compra, le notificaremos cuando el pago haya sido aprobado"]);
            }

            

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    /*function userFetch($page = 1){

        try{
            
            $user = JWTAuth::parseToken()->toUser();
            $skip = ($page-1) * 10;

            $purchases = Purchase::with('post', 'payments', 'post.user', 'post.category', 'post.discountDays', 'post.location')->where('user_id', $user->id)->skip($skip)->take(10)->get();
            $purchasesCount = Purchase::with('post', 'payments', 'post.user', 'post.category', 'post.discountDays', 'post.location')->where('user_id', $user->id)->count();

            return response()->json(["success" => true, "purchases" => $purchases, "purchasesCount" => $purchasesCount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }*/

}
