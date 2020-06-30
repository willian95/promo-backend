<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
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

            $posts = Post::with('user', 'discountDays', 'category', 'commune')->where("commune_id", $request->location_id)->whereDate("start_date", "<=", $todaysDate->format('Y-m-d'))->whereDate("due_date", ">=", $todaysDate->format('Y-m-d'))->orderBy("id", "desc")->get();
            $postsCount = Post::with('user', 'discountDays', 'category', 'commune')->where("commune_id", $request->location_id)->whereDate("start_date", "<=", $todaysDate->format('Y-m-d'))->whereDate("due_date", ">=", $todaysDate->format('Y-m-d'))->count();

            return response()->json(["success" => true, "posts" => $posts, "postsCount" => $postsCount]);


        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

}
