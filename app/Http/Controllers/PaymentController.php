<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PaymentUpdateRequest;
use App\Payment;

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

            return response()->json(["success" => true, "msg" => "Pago actualizado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

}
