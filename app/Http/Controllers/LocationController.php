<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LocationStoreRequest;
use App\Location;

class LocationController extends Controller
{
    
    function store(LocationStoreRequest $request){

        try{

            $location = new Location;
            $location->name = $request->name;
            $location->save();
            
            return response()->json(["success" => true, "msg" => "Comuna creada"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function fetch(){
        try{

            $locations = Location::all();
            return response()->json(["success" => true, "locations" => $locations]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }
        
    }

}
