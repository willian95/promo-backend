<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Purchase;
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
            })->with("post", "user", "productsPurchase", "productsPurchase.postProduct")->skip($skip)->take(20)->get();
            $salesCount = Purchase::whereHas("post.user", function($q) use($user){
                $q->where('user_id', $user->id);
            })->with("post", "user")->count();
            
            return response()->json(["success" => true, "sales" => $sales, "salesCount" => $salesCount]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

    function deliver(Request $request){
        try{

            Purchase::where("id", $request->id)->update(["shipping_state" => "entregado"]);
            return response()->json(["success" => true, "msg" => "Articulo entregado, en espera de la confirmación del cliente"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }
    }

}
