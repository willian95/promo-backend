<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{

    function loginView(){
        return view("user.login");
    }

    function registerView(){
        return view("user.register");
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(["success" => false, 'msg' => 'Usuario no encontrado']);
            }
        } catch (JWTException $e) {
            return response()->json(["success" => false,  'msg' => 'No se pudo crear el token']);
        }

        $user = User::where('email', $request->email)->first();

        if($user->email_verified_at != null){
            return response()->json(["success" => true, "msg" =>"Has iniciado sesión", "token" => $token, "user" => $user]);
        }else{
            return response()->json(["success" => false,  'msg' => 'Aún no has validado tu email']);
        }

    }

    public function getAuthenticatedUser(Request $request)
    {
        $user = JWTAuth::parseToken()->toUser();
        return response()->json(compact('user'));
    }

    function register(RegisterRequest $request){

        try{

            $registerHash = Str::random(40);

            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->address = $request->address;
            $user->password = bcrypt($request->password);
            $user->location_id = $request->locationId;
            $user->telephone = $request->telephone;
            $user->register_hash = $registerHash;
            $user->save();

            $token = JWTAuth::fromUser($user);
            $user = User::find($user->id);

            $messageUser = "Hola ".$user->name."! Haz click en el siguiente enlace para validar tu correo";
            $to_email = $user->email;
            $to_name = $user->name;
            
            $data = ["messageMail" => $messageUser, "registerHash" => $registerHash];
            \Mail::send("emails.confirmRegisterMail", $data, function($message) use ($to_name, $to_email) {

                $message->to($to_email, $to_name)->subject("¡Valida tu correo!");
                $message->from( env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));

            });

            return response()->json(["success" => true, "msg" => "Usuario registrado", "token" => $token, "user" => $user]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function validateMail($registerHash){

        try{

            $user = User::where("register_hash", $registerHash)->first();
            $user->email_verified_at = Carbon::now();
            $user->update();

            return redirect()->to("/");

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }
    
}
