<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Purchase;
use App\User;
use App\Post;
use JWTAuth;

class SaleController extends Controller
{
    
    function index(){
        return view("user.sales.index");
    }

    function userFetch($page = 1){

        try{

            $skip = ($page-1) * 20;

            $user = JWTAuth::parseToken()->toUser();
            $sales = Purchase::whereHas("post", function($q) use($user){
                $q->where('user_id', $user->id);
            })->with("post", "user", "productsPurchase", "productsPurchase.postProduct", "user.commune")->skip($skip)->take(20)->get();
            $salesCount = Purchase::whereHas("post.user", function($q) use($user){
                $q->where('user_id', $user->id);
            })->with("post", "user", "user.commune")->count();
            
            return response()->json(["success" => true, "sales" => $sales, "salesCount" => $salesCount]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

    function deliver(Request $request){
        try{

            Purchase::where("id", $request->id)->update(["shipping_state" => "entregado"]);

            $purchase = Purchase::where("id", $request->id)->first();

            $post = Post::where("id", $purchase->post_id)->first();
            $seller = User::where("id", $post->user_id)->first();
            $buyer = User::where("id", $purchase->user_id)->first();
            $messageBuyer = "Hola ".$buyer->name."! El vendedor ".$seller->name." indica que te ha entregado los siguientes platos: ";
            $purchaseProduct = ProductPurchase::with("postProduct")->where("purchase_id", $purchase->id)->get();
            $to_email = $buyer->email;
            $to_name = $buyer->name;
            
            $data = ["messageMail" => $messageBuyer, "purchaseProducts" => $purchaseProduct, "messageTo" => "buyer"];
            \Mail::send("emails.deliverMail", $data, function($message) use ($to_name, $to_email) {

                $message->to($to_email, $to_name)->subject("¡Has recibido tus platos!");
                $message->from( env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));

            });

            $messageSeller = "Hola ".$seller->name."! Has entregado a ".$buyer->name." los siguientes platos: ";
            $purchaseProduct = ProductPurchase::with("postProduct")->where("purchase_id", $purchase->id)->get();
            $to_email = $seller->email;
            $to_name = $seller->name;
            
            $data = ["messageMail" => $messageSeller, "purchaseProducts" => $purchaseProduct, "messageTo" => "seller"];
            \Mail::send("emails.deliverMail", $data, function($message) use ($to_name, $to_email) {

                $message->to($to_email, $to_name)->subject("¡Has entregado tus platos!");
                $message->from( env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));

            });

            $messageAdmin = "Hola Admin! El vendedor ".$seller->name." ha entregado a ".$buyer->name." los siguientes platos: ";
            $purchaseProduct = ProductPurchase::with("postProduct")->where("purchase_id", $purchase->id)->get();
            $to_email = $seller->email;
            $to_name = $seller->name;
            
            $data = ["messageMail" => $messageAdmin, "purchaseProducts" => $purchaseProduct, "messageTo" => "admin"];
            \Mail::send("emails.deliverMail", $data, function($message) use ($to_name, $to_email) {

                $message->to($to_email, $to_name)->subject("¡Entrega realizada!");
                $message->from( env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));

            });


            return response()->json(["success" => true, "msg" => "Articulo entregado, en espera de la confirmación del cliente"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }
    }

}
