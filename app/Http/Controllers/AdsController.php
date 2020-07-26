<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AdminAdsStoreRequest;
use App\Http\Requests\AdminAdsUpdateRequest;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use App\Ad;

class AdsController extends Controller
{
    function index(){
        return view("admin.ads.index");
    }

    function store(AdminAdsStoreRequest $request){

        try{
            
            $imageData = $request->get('image');
            $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
            Image::make($request->get('image'))->save(public_path('images/ads/').$fileName, 50);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Hubo un error al cargar la imagen", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

        try{

            $ad = new Ad;
            $ad->image = $fileName;
            $ad->link = $request->link;
            $ad->save();

            return response()->json(["success" => true, "msg" => "Publicidad creada"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function fetch($page = 1){

        try{

            $skip = ($page-1) * 20;

            $ads = Ad::skip($skip)->take(20)->orderBy('id', 'desc')->get();
            $adsCount = Ad::count();

            return response()->json(["success" => true, "ads" => $ads, "adsCount" => $adsCount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function update(AdminAdsUpdateRequest $request){

        try{
            
            if($request->get('image') != null){
                $imageData = $request->get('image');
                $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
                Image::make($request->get('image'))->save(public_path('images/ads/').$fileName, 50);
            }
        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Hubo un error al cargar la imagen", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

        try{

            $ad = Ad::where("id", $request->id)->first();
            if($request->get('image') != null){
                $ad->image = $fileName;
            }
            $ad->link = $request->link;
            $ad->update();

            return response()->json(["success" => true, "msg" => "Publicidad creada"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function delete(Request $request){

        try{

            $ad = Ad::where("id", $request->id)->first();
            $ad->delete();

            return response()->json(["success" => true, "msg" => "Publicidad eliminada"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        } 

    }

}
