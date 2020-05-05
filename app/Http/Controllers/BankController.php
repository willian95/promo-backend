<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BankStoreRequest;
use App\Bank;

class BankController extends Controller
{
    
    function store(BankStoreRequest $request){

        try{

            $bank = new Bank;
            $bank->holder_name = $request->holderName;
            $bank->holder_rut = $request->holderRut;
            $bank->bank_name = $request->bankName;
            $bank->account_number = $request->accountNumber;
            $bank->account_type = $request->accountType;
            $bank->save();

            return response()->json(["success" => true, "msg" => "Banco registrado"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

    function fetch(){

        try{

            $banks = Bank::all();
            return response()->json(["success" => true, "banks" => $banks]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

}
