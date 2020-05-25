<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PaymentUpdateRequest;
use App\Payment;
use App\Purchase;

class PaymentController extends Controller
{
    
    function fetch(){

        try{

            $payments = Payment::with("purchase", "purchase.post", "purchase.post.user", "user", "bank")->get();
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
                    $purchase->update();
                }

                else if($purchase->payment_type == "reservation"){

                    if(Payment::where('purchase_id', $payment->purchase_id)->where('state', "aprobado")->count() >= 2){
                        
                        $purchase->is_payment_complete = 1;
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
