<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{

    function index(){
        return view("admin.users.index");
    }

    function fetch($page = 1){

        try{

            $skip = ($page-1) * 20;

            $users = User::skip($skip)->take(20)->orderBy('id', 'desc')->get();
            $usersCount = User::count();

            return response()->json(["success" => true, "users" => $users, "usersCount" => $usersCount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function delete(Request $request){
        
        try{

            $post = User::where("id", $request->id)->first();
            $post->delete();

            return response()->json(["success" => true, "msg" => "Usuario eliminado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

}
