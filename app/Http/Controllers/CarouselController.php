<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CarouselStoreRequest;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use App\Carousel;

class CarouselController extends Controller
{
    
    function index(){

        return view("admin.carousel.index");

    }

    function fetch(){

        try{

            $carousels = Carousel::all();
            return response()->json(["success" => true, "carousels" => $carousels]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Ha ocurrido un problema", "ln" => $e->getLine(), "msg" => $e->getMessage()]);
        }

    }

    function store(CarouselStoreRequest $request){
        try{
            
            $imageData = $request->get('image');
            $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
            Image::make($request->get('image'))->save(public_path('images/ads/').$fileName, 50);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Hubo un error al cargar la imagen", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

        try{

            $carousel = new Carousel;
            $carousel->image = url('/').'/images/ads/'.$fileName;
            $carousel->text = $request->text;
            $carousel->link = $request->link;
            $carousel->save();

            return response()->json(["success" => true, "msg" => "Carrusel creado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }
    }

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

            $carousel = Carousel::where("id", $request->id)->first();
            if($request->get('image') != null){
                $carousel->image = url('/').'/images/ads/'.$fileName;
            }
            $carousel->text = $request->text;
            $carousel->link = $request->link;
            $carousel->update();

            return response()->json(["success" => true, "msg" => "Carrusel actualizado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function delete(Request $request){

        try{

            $carousel = Carousel::where("id", $request->id)->first();
            $carousel->delete();

            return response()->json(["success" => true, "msg" => "Carrusel eliminado"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        } 

    }

}
