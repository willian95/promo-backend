<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class AdminController extends Controller
{
    function latestPosts(){

        try{

            $posts = Post::with("user", "category")->has("user")->take(5)->orderBy("id", "desc")->get();
            return response()->json(["success" => true, "latestPosts" => $posts]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor", "msg" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }
}
