<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use App\Category;

class CategoryController extends Controller
{
    
    function store(CategoryStoreRequest $request){
        
        try{
            
            $imageData = $request->get('image');
            $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
            Image::make($request->get('image'))->save(public_path('images/categories/').$fileName, 50);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Hubo un error al cargar la imagen", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

        try{

            $category = new Category;
            $category->name = $request->name;
            $category->description = $request->description;
            $category->image = $fileName;
            $category->color = $request->color;
            $category->save();
            
            return response()->json(["success" => true, "msg" => "Categoría creada"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function fetch(){
        try{
            
            $categories = Category::all();
            return response()->json(["success" => true, "categories" => $categories]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }
        
    }

    function delete(Request $request){

        try{

            $category = Category::find($request->id);
            $category->delete();

            return response()->json(["success" => true, "msg" => "Categoría eliminada"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

    function update(CategoryUpdateRequest $request){
        
        if(isset($request->image)){
            try{
            
                $imageData = $request->get('image');
                $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
                Image::make($request->get('image'))->save(public_path('images/categories/').$fileName, 50);
    
            }catch(\Exception $e){
    
                return response()->json(["success" => false, "msg" => "Hubo un error al cargar la imagen", "err" => $e->getMessage(), "ln" => $e->getLine()]);
    
            }
    
        }
        try{

            $category = Category::find($request->id);
            $category->name = $request->name;
            $category->description = $request->description;
            if(isset($request->image)){
                $category->image = $fileName;
            }
            $category->color = $request->color;
            $category->update();

            return response()->json(["success" => true, "msg" => "Categoría actualizada"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

}
