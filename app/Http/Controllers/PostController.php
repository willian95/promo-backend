<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostStoreRequest;
use App\Post;
use Carbon\Carbon;
use App\DiscountDay;
use JWTAuth;

class PostController extends Controller
{
    
    function store(PostStoreRequest $request){

        try{

            $now = Carbon::now();
            $saleDate = Carbon::parse($request->saleDate);
            $startDate = Carbon::parse($request->saleDate)->subDays(6);
            $dueDate = Carbon::parse($request->saleDate)->addDays(6);

            if($startDate->greaterThanOrEqualTo($now)){

                $user = JWTAuth::parseToken()->toUser();

                $post = new Post;
                $post->user_id = $user->id;
                $post->title = $request->title;
                $post->description = $request->description;
                $post->image = "https://images.pexels.com/photos/461198/pexels-photo-461198.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500";
                $post->amount = $request->amount;
                $post->price = $request->price;
                $post->category_id = $request->categoryId;
                $post->location_id = $user->location_id;
                $post->sale_date = $saleDate->format('y-m-d');
                $post->start_date = $startDate->format('y-m-d');
                $post->due_date = $dueDate->format('y-m-d');
                $post->save();

                $discount = new DiscountDay;
                $discount->post_id = $post->id;
                $discount->date = Carbon::parse($request->saleDate)->subDays(6);
                $discount->discount = $request->discount1;
                $discount->save();

                $discount = new DiscountDay;
                $discount->post_id = $post->id;
                $discount->date = Carbon::parse($request->saleDate)->subDays(5);
                $discount->discount = $request->discount2;
                $discount->save();

                $discount = new DiscountDay;
                $discount->post_id = $post->id;
                $discount->date = Carbon::parse($request->saleDate)->subDays(4);
                $discount->discount = $request->discount3;
                $discount->save();

                $discount = new DiscountDay;
                $discount->post_id = $post->id;
                $discount->date = Carbon::parse($request->saleDate)->subDays(3);
                $discount->discount = $request->discount4;
                $discount->save();

                $discount = new DiscountDay;
                $discount->post_id = $post->id;
                $discount->date = Carbon::parse($request->saleDate)->subDays(2);
                $discount->discount = $request->discount5;
                $discount->save();

                $discount = new DiscountDay;
                $discount->post_id = $post->id;
                $discount->date = Carbon::parse($request->saleDate)->subDays(1);
                $discount->discount = $request->discount6;
                $discount->save();

                $discount = new DiscountDay;
                $discount->post_id = $post->id;
                $discount->date = Carbon::parse($request->saleDate);
                $discount->discount = $request->discount7;
                $discount->save();

                return response()->json(["success" => true, "msg" => "Publicación realizada"]);

            }else{

                return response()->json(["success" => false, "msg" => "Deben existir al menos 7 días antes de la fecha de inicio"]);

            }

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

}
