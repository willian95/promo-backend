<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Purchase;
use App\Payment;
use JWTAuth;
use App\Http\Requests\PurchaseStoreRequest;
use Tymon\JWTAuth\Exceptions\JWTException;

class PurchaseController extends Controller
{
    
    function reserve(PurchaseStoreRequest $request){

        try{

            $user = JWTAuth::parseToken()->toUser();

            if($request->action == "make-purchase"){
                $purchase = new Purchase;
                $purchase->user_id = $user->id;
                $purchase->post_id = $request->postId;
                $purchase->price = $request->price;
                $purchase->payment_type = $request->type;
                $purchase->amount = $request->amount;
                $purchase->save();

                $payment = new Payment;
                $payment->purchase_id = $purchase->id;
                $payment->user_id = $user->id;
                $payment->transfer = $request->transfer;
                $payment->bank_id = $request->bank;
                $payment->amount_to_pay = $request->amountToPay;
                $payment->save();

            }else{

                $payment = new Payment;
                $payment->purchase_id = $request->purchaseId;
                $payment->user_id = $user->id;
                $payment->transfer = $request->transfer;
                $payment->bank_id = $request->bank;
                $payment->amount_to_pay = $request->amountToPay;
                $payment->save();

            }

            

            return response()->json(["success" => true, "msg" => "Ha realizado una reservación, le notificaremos cuando el pago haya sido aprobado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function userFetch($page = 1){

        try{
            
            $user = JWTAuth::parseToken()->toUser();
            $skip = ($page-1) * 10;

            $purchases = Purchase::with('post', 'payments', 'post.user', 'post.category', 'post.discountDays', 'post.location')->where('user_id', $user->id)->skip($skip)->take(10)->get();
            $purchasesCount = Purchase::with('post', 'payments', 'post.user', 'post.category', 'post.discountDays', 'post.location')->where('user_id', $user->id)->count();

            return response()->json(["success" => true, "purchases" => $purchases, "purchasesCount" => $purchasesCount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

}
