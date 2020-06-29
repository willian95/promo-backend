<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PaymentUpdateRequest;
use App\Payment;
use App\Purchase;
use JWTAuth;

class PaymentController extends Controller
{
    function transferViews(){
        return view("admin.transfers.index");
    }

    function myTransferViews(){
        return view("user.myTransfer");
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
