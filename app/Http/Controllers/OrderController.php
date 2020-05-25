<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class OrderController extends Controller
{
    
    function fetchReservations(){

        try{

            $user = JWTAuth::parseToken()->toUser();
            $reservations = Post::where('user_id', $user->id)->with('purchase', 'purchase.payments', 'purchase.user')->get();
            return response()->json(["success" => true, "reservations" => $reservations]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

}
