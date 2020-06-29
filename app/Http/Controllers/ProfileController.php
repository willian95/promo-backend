<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileUpdateRequest;
use App\User;
use JWTAuth;
use App\Commune;
use App\Region;

class ProfileController extends Controller
{
    
    function index(){
        return view("user.profile.myProfile");
    }

    function myData(){

        try{

            $user = JWTAuth::parseToken()->toUser();
            $commune = Commune::where("id", $user->location_id)->first();
            return response()->json(["success" => true, "user" => $user, "commune" => $commune]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }
    }

    function update(ProfileUpdateRequest $request){

        try{

            $authUser = JWTAuth::parseToken()->toUser();
            $user = User::where("id", $authUser->id)->first();
            $user->name = $request->name;
            $user->address = $request->address;
            $user->location_id = $request->commune;
            $user->telephone = $request->telephone;
            $user->web_site = $request->webSite;
            $user->facebook = $request->facebook;
            $user->instagram = $request->instagram;
            $user->update();

            return response()->json(["success" => true, "msg" => "Datos actualizados satisfactoriamente"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

    function show($id){

        $user = User::where("id", $id)->first();
        $commune = Commune::where("id", $user->location_id)->first();
        $region = Region::where("id", $commune->region_id)->first();
        return view("user.profile.userProfile", ["user" => $user, "commune" => $commune->name, "region" => $region->name]);
    }


}
