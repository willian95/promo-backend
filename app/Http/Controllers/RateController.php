<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RateStoreRequest;
use App\Purchase;
use App\Rating;
use JWTAuth;

class RateController extends Controller
{
    
    function store(RateStoreRequest $request){

        try{
            $user = JWTAuth::parseToken()->toUser();
            Purchase::where("id", $request->purchaseId)->update(["is_seller_rated" => 1]);

            $rating = new Rating;
            $rating->user_id = $request->sellerId;
            $rating->qualifier_id = $user->id;
            $rating->rate = $request->rate;
            $rating->comment = $request->comment;
            $rating->save();

            return response()->json(["success" => true, "msg" => "Calificación realizada"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

}
