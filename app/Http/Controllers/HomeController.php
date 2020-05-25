<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;
use Carbon\Carbon;

class HomeController extends Controller
{
    
    function fetch(){
        try{

            $posts = Post::with('user', 'discountDays', 'category', 'location')->get();
            $todaysDate = Carbon::now();
            return response()->json(["success" => true, "posts" => $posts, "todaysDate" => $todaysDate]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }
    }

    function fetchCategories(){
        try{

            $categories = Category::all();
            return response()->json(["success" => true, "categories" => $categories]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }
    }

}
