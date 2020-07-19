<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileUpdateRequest;
use App\User;
use JWTAuth;
use App\Commune;
use App\Region;
use App\Rating;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;

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
        
        if($request->get('image') != null){
            try{
                
                $imageData = $request->get('image');
                $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
                Image::make($request->get('image'))->save(public_path('images/users/').$fileName, 50);

            }catch(\Exception $e){

                return response()->json(["success" => false, "msg" => "Hubo un error al cargar la imagen", "err" => $e->getMessage(), "ln" => $e->getLine()]);

            }
        }

        try{

            $deliveryDaysString="";
            $i = 0;
            foreach($request->checkedDeliveryDays as $deliveryDays){
                
                if($i == 0){
                    $deliveryDaysString = $deliveryDays;
                }else{
                    $deliveryDaysString = $deliveryDaysString.",".$deliveryDays;
                }
                
                $i++;
            }

            $openDaysString="";
            $i = 0;
            foreach($request->checkedOpenDays as $openDays){
                
                if($i == 0){
                    $openDaysString = $openDays;
                }else{
                    $openDaysString = $openDaysString.",".$openDays;
                }
                
                $i++;
            }

            

            $authUser = JWTAuth::parseToken()->toUser();
            $user = User::where("id", $authUser->id)->first();
            $user->name = $request->name;
            $user->address = $request->address;
            $user->location_id = $request->commune;
            $user->telephone = $request->telephone;
            $user->web_site = $request->webSite;
            $user->facebook = $request->facebook;
            $user->instagram = $request->instagram;
            $user->has_delivery = $request->hasDelivery;
            $user->has_delivery = $request->hasDelivery;
            $user->delivery_tax = $request->deliveryPrice;
            $user->deliver_days = $deliveryDaysString;
            $user->open_days = $openDaysString; 
            if($request->get('image') != null){
                
                $user->image = $fileName;
            }
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
