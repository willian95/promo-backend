<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(["success" => false, 'msg' => 'Usuario no encontrado']);
            }
        } catch (JWTException $e) {
            return response()->json(["success" => false,  'error' => 'No se pudo crear el token'], 500);
        }

        $user = User::where('email', $request->email)->first();

        return response()->json(["success" => true, "msg" =>"Has iniciado sesión", "token" => $token, "user" => $user]);
    }

    public function getAuthenticatedUser(Request $request)
    {
        $user = JWTAuth::parseToken()->toUser();
        return response()->json(compact('user'));
    }

    function register(RegisterRequest $request){

        try{

            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->location_id = $request->locationId;
            $user->save();

            $token = JWTAuth::fromUser($user);
            $user = User::find($user->id);

            return response()->json(["success" => true, "msg" => "Usuario registrado", "token" => $token, "user" => $user]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }
    
}
