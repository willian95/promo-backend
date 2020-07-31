<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ForgotPasswordVerifyEmailRequest;
use App\Http\Requests\ChangPasswordRequest;
use Illuminate\Support\Str;
use App\User;

class ForgotPasswordController extends Controller
{
    
    function index(){
        return view("user.forgotPassword");
    }

    function verifyEmail(ForgotPasswordVerifyEmailRequest $request){

        try{

            $forgotHash = Str::random(40);
            $user = User::where("email", $request->email)->first();
            $user->forgot_password_hash = $forgotHash;
            $user->update();    

            $to_name = $user->name;
            $to_email = $user->email;

            $data = ["forgotHash" => $forgotHash];
            \Mail::send("emails.forgotPassword", $data, function($message) use ($to_name, $to_email) {

                $message->to($to_email, $to_name)->subject("¡Cambio de clave!");
                $message->from( env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));

            });

            return response()->json(["success" => true, "msg" => "Verifique su bandeja de entrada"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

    public function changePasswordView($forgotHash){

        try{

            $user = User::where('forgot_password_hash', $forgotHash)->firstOrFail();
            return view("user.changePassword", ["hash" => $forgotHash]);

        }catch(\Exception $e){

            abort(503);

        }

    }

    function changePassword(ChangPasswordRequest $request){

        try{

            $user = User::where("forgot_password_hash", $request->hash)->firstOrFail();
            $user->forgot_password_hash = null;
            $user->password = bcrypt($request->password);
            $user->update();    

            return response()->json(["success" => true, "msg" => "Contraseña actualizada"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

}
