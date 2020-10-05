<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\HomeBanner;
use Carbon\Carbon;

class HomeBannerController extends Controller
{
    
    function update(Request $request){

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

            $homeBanner = HomeBanner::where("id", $request->banner_id)->first();
            if($request->get('image') != null){
                $homeBanner->image = url('/').'/images/ads/'.$fileName;
            }
            $homeBanner->link = $request->link;
            $homeBanner->status = $request->status;
            $homeBanner->update();

            return response()->json(["success" => true, "msg" => "Banner Actualizado"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Hubo un problema", "err"=> $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

}
