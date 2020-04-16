<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class HomeController extends Controller
{
    
    function fetch(){
        try{

            $posts = Post::with('user', 'discountDays', 'category', 'location')->get();
            return response()->json(["success" => true, "posts" => $posts]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }
    }

}
