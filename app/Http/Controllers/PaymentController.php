<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PaymentUpdateRequest;
use App\Payment;
use App\Purchase;
use App\ProductPurchase;
use App\Post;
use App\User;
use JWTAuth;

class PaymentController extends Controller
{
    function transferViews(){
        return view("admin.transfers.index");
    }

    function myTransferViews(){
        return view("user.myTransfer");
    }

    function store(Request $request){

        try{

            $user = JWTAuth::parseToken()->toUser();

            if($request->paymentType == "reservation"){

                $purchase = new Purchase;
                $purchase->user_id = $user->id;
                $purchase->price = $request->price;
                $purchase->is_payment_complete = 0;
                $purchase->payment_type = $request->paymentType;
                $purchase->total = $request->total;
                $purchase->post_id = $request->postId;
                $purchase->has_delivery = $user->has_delivery;
                $purchase->save();

                foreach($request->productsPurchase as $product){

                    $productPurchase = new ProductPurchase;
                    $productPurchase->purchase_id = $purchase->id;
                    $productPurchase->post_product_id = $product["product"]["id"];
                    $productPurchase->amount = $product["amount"]; 
                    $productPurchase->price = $product["price"];
                    $productPurchase->save();

                }

                $payment = new Payment;
                $payment->purchase_id = $purchase->id;
                $payment->user_id = $user->id;
                $payment->state = "en proceso";
                $payment->bank_id= $request->bankId;
                $payment->amount_to_pay = $request->amountToPay;
                $payment->rut = $request->rut;
                $payment->transfer = "0";
                $payment->save();
            
            }else{

                $payment = new Payment;
                $payment->purchase_id = $request->purchaseId;
                $payment->user_id = $user->id;
                $payment->transfer = $request->transfer;
                $payment->bank_id = $request->bank;
                $payment->amount_to_pay = $request->amountToPay;
                $payment->rut = $request->rut;
                $payment->transfer = "0";
                $payment->save();

            }

            $title = "Verifica esta transferencia";
            $messageBuyer = "";

            if($request->paymentType == "reservation"){
                
                $messageBuyer = "El usuario ".$user->name." ha realizado una transferencia. Verifica esta transacción. <p>Nombre: ".$user->name."<p>"."<p>Email: ".$user->email."<p>"."<p>RUT: ".$request->rut."<p>";
            }else{
                $messageBuyer = "El usuario ".$user->name." ha realizado una compra. Verifica esta transacción";
            }

            $post = Post::find($request->postId);
            $seller = User::where("id", $post->user_id)->first();
            $to_email = $seller->email;
            $to_name = $seller->name;
            $purchaseProduct = ProductPurchase::with("postProduct")->where("purchase_id", $purchase->id)->get();

            $data = ["messageMail" => $messageBuyer, "purchaseProducts" => $purchaseProduct, "messageTo" => "seller", "purchaseId" => $purchase->id];
            \Mail::send("emails.purchaseMail", $data, function($message) use ($to_name, $to_email, $title) {

                $message->to($to_email, $to_name)->subject($title);
                $message->from( env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));

            });

            return response()->json(["success" => true, "msg" => "Has notificado la realización de una transferencia"]);


        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }
    
    function fetch($page = 1){

        try{

            $skip = ($page-1) * 20;

            $payments = Payment::with("purchase", "purchase.post", "purchase.post.user", "user", "bank")->skip($skip)->take(20)->orderBy('id', 'desc')->get();
            $paymentsCount = Payment::with("purchase", "purchase.post", "purchase.post.user", "user", "bank")->count();

            return response()->json(["success" => true, "payments" => $payments, "paymentsCount" => $paymentsCount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function fetchMyPayments(){

        try{
            $user = JWTAuth::parseToken()->toUser();
            $payments = Payment::with("purchase", "purchase.post", "purchase.post.user", "user", "bank")->where("user_id", $user->id)->get();
            return response()->json(["success" => true, "payments" => $payments]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function update(PaymentUpdateRequest $request){

        try{

            $payment = Payment::find($request->paymentId);
            $payment->state = $request->state;
            $payment->comment = $request->comment;
            $payment->update();

            if($payment->state == "aprobado"){

                $purchase = Purchase::find($payment->purchase_id);

                if($purchase->payment_type == "purchase"){
                    $purchase->is_payment_complete = 1;
                    $purchase->shipping_state = "en proceso";
                    $purchase->update();
                }

                else if($purchase->payment_type == "reservation"){

                    if(Payment::where('purchase_id', $payment->purchase_id)->where('state', "aprobado")->count() >= 2){
                        
                        $purchase->is_payment_complete = 1;
                        $purchase->shipping_state = "en proceso";
                        $purchase->update();

                    }

                }

            }

            return response()->json(["success" => true, "msg" => "Pago actualizado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

}
