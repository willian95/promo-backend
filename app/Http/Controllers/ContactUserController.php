<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactUserStoreRequest;
use App\ContactUser;

class ContactUserController extends Controller
{
    
    function store(ContactUserStoreRequest $request){

        try{

            $contactUser = new ContactUser;
            $contactUser->name = $request->name;
            $contactUser->email = $request->email;
            $contactUser->password = $request->password;
            $contactUser->seller = $request->seller;
            $contactUser->buyer = $request->buyer;
            $contactUser->category1 = $request->category1;
            $contactUser->category2 = $request->category2;
            $contactUser->category3 = $request->category3;
            $contactUser->category4 = $request->category4;
            $contactUser->category5 = $request->category5;
            $contactUser->save();

            return response()->json(["success" => true, "msg" => "Te has registrado exitosamente"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Estamos teniendo problemas técnicos","err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

}
