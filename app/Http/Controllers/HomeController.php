<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;
use Carbon\Carbon;
use JWTAuth;

class HomeController extends Controller
{
    
    function fetch(){
        try{

            $user = JWTAuth::parseToken()->toUser();
            $todaysDate = Carbon::now()->addDays(5);

            $posts = Post::with('user', 'discountDays', 'category', 'commune')->where("commune_id", $user->location_id)->whereDate("start_date", "<=", $todaysDate->format('Y-m-d'))->whereDate("due_date", ">=", $todaysDate->format('Y-m-d'))->orderBy("id", "desc")->get();

            return response()->json(["success" => true, "posts" => $posts, "todaysDate" => $todaysDate]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }
    }

    function guestFetch(){
        try{

            $todaysDate = Carbon::now();

            $posts = Post::with('user', 'discountDays', 'category', 'commune')->where("start_date", "<=", $todaysDate->format('Y-m-d'))->where("due_date", ">=", $todaysDate->format('Y-m-d'))->inRandomOrder()->take(12)->orderBy("id", "desc")->get();
            return response()->json(["success" => true, "posts" => $posts, "todaysDate" => $todaysDate]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

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
