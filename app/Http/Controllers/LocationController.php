<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LocationStoreRequest;
use App\Region;
use App\Commune;

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

    function regionFetch(){
        try{

            $regions = Region::all();
            return response()->json(["success" => true, "regions" => $regions]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }
        
    }

    function CommuneFetch($region_id){
        try{

            $communes = Commune::where("region_id", $region_id)->get();
            return response()->json(["success" => true, "communes" => $communes]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }
        
    }

}
