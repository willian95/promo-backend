<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\DiscountDay;
use Carbon\Carbon;

class ExplorerController extends Controller
{
    function index(){
        return view("user.explorer");
    }

    function fetch(Request $request){

        try{

            $skip = ($request->page-1) * 20;
            $todaysDate = Carbon::now();

            $posts = Post::with('user', 'discountDays', 'category', 'commune')->where("commune_id", $request->commune_id)->whereDate("start_date", "<=", $todaysDate->format('Y-m-d'))->whereDate("due_date", ">=", $todaysDate->format('Y-m-d'))->orderBy("id", "desc")->get();
            $postsCount = Post::with('user', 'discountDays', 'category', 'commune')->where("commune_id", $request->commune_id)->whereDate("start_date", "<=", $todaysDate->format('Y-m-d'))->whereDate("due_date", ">=", $todaysDate->format('Y-m-d'))->count();

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
                    "post" => $pots = $posts,
                    "overall" => $overall,
                    "discountPercentage" => $discount
                ];

            }

            return response()->json(["success" => true, "posts" => $postArray, "postsCount" => $postsCount]);


        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

}
