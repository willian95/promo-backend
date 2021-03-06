<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;
use App\DiscountDay;
use Carbon\Carbon;
use JWTAuth;

class HomeController extends Controller
{
    
    function fetch(){
        try{

            $user = JWTAuth::parseToken()->toUser();
            $todaysDate = Carbon::now();

            $posts = Post::with('user', 'discountDays', 'category', 'commune', "products", "user.ratings")->where("commune_id", $user->commune_id)->whereDate("start_date", "<=", $todaysDate->format('Y-m-d'))->whereDate("due_date", ">=", $todaysDate->format('Y-m-d'))->orderBy("id", "desc")->get();
            $postArray = [];

            foreach($posts as $post){

                $rate = 0;

                foreach($post->user->ratings as $rating){

                    $rate = $rate + $rating->rate;

                }

                if($rate > 0){
                    $overall = number_format($rate / count($post->user->ratings), 1, ",", ".");
                }else{
                    $overall= 0;
                }
                
                $discount = DiscountDay::where("date", $todaysDate->format('Y-m-d'))->where("post_id", $post->id)->first();

                if($discount){
                    $discount = $discount->discount;
                }else{
                    $discount = 0;
                }

                $postArray[] = [
                    "post" => $post,
                    "overall" => $overall,
                    "discountPercentage" => $discount
                ]; 
//
            }

            return response()->json(["success" => true, "posts" => $postArray, "todaysDate" => $todaysDate]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }
    }

    function guestFetch(){
        try{

            $todaysDate = Carbon::now();

            $posts = Post::with('user', 'discountDays', 'category', 'commune', "user.ratings")->where("start_date", "<=", $todaysDate->format('Y-m-d'))->where("due_date", ">=", $todaysDate->format('Y-m-d'))->inRandomOrder()->take(12)->orderBy("id", "desc")->get();

            $postArray = [];

            foreach($posts as $post){

                $rate = 0;

                foreach($post->user->ratings as $rating){

                    $rate = $rate + $rating->rate;

                }

                if($rate > 0){
                    $overall = number_format($rate / count($post->user->ratings), 1, ",", ".");
                }else{
                    $overall= 0;
                }

                $discount = DiscountDay::where("date", $todaysDate->format('Y-m-d'))->where("post_id", $post->id)->first();

                if($discount){
                    $discount = $discount->discount;
                }else{
                    $discount = 0;
                }

                $postArray[] = [
                    "post" => $post,
                    "overall" => $overall,
                    "discountPercentage" => $discount
                ];

            }

            return response()->json(["success" => true, "posts" => $postArray, "todaysDate" => $todaysDate]);

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
