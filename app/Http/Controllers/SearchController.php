<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Region;
use App\Commune;

class SearchController extends Controller
{
    
    function search(Request $request){

        try{

            $words = explode(' ',strtolower($request->search)); // coloco cada palabra en un espacio del array
            $wordsToDelete = array('de', 'y', 'el', 'la', 'lo');
            $regionsArray = [];
            $regionsCommunesArray = [];

            $words = array_values(array_diff($words,$wordsToDelete));

            $dataAmount = 18;
            $skip = ($request->page - 1) * $dataAmount;

            $communes = Commune::where(function ($query) use($words) {
                for ($i = 0; $i < count($words); $i++){
                    $query->orWhere('name', "like", "%".$words[$i]."%");
                }
            })->get();

            $regions = Region::where(function ($query) use($words) {
                for ($i = 0; $i < count($words); $i++){
                    $query->orWhere('name', "like", "%".$words[$i]."%");
                }
            })->get();

            foreach($regions as $region){
                array_push($regionsArray, $region->id);
            }
            
            $regionCommunes = $communes::whereIn($regionsArray)->get();

            foreach($regionCommunes as $regionCommune){
                array_push($regionsCommunesArray, $regionCommune->id);
            }
            
            foreach($communes as $commune){
                array_push($regionsCommunesArray, $commune->id);
            }

            $posts = Post::with('user', 'discountDays', 'category', 'commune')->has("user")->has('discountDays')->has('category')->has('commune')
            ->where(function ($query) use($words) {
                for ($i = 0; $i < count($words); $i++){
                    if($words[$i] != ""){
                        //$query->orWhere('description', "like", "%".$words[$i]."%");
                        $query->orWhere('title', "like", "%".$words[$i]."%");
                        $query->orWhere('description', "like", "%".$words[$i]."%");
                        
                    }
                }      
            })
            ->whereDate('due_date', '>', Carbon::today()->toDateString())
            ->take($dataAmount)
            ->orderBy("id", "desc")
            ->orWhereIn($regionsCommunesArray)
            ->get();

            $postsCount = Post::with('user', 'discountDays', 'category', 'commune')->has("user")->has('discountDays')->has('category')->has('commune')
            ->where(function ($query) use($words) {
                for ($i = 0; $i < count($words); $i++){
                    if($words[$i] != ""){
                        //$query->orWhere('description', "like", "%".$words[$i]."%");
                        $query->orWhere('title', "like", "%".$words[$i]."%");
                        $query->orWhere('description', "like", "%".$words[$i]."%");
                        
                    }
                }      
            })
            ->whereDate('due_date', '>', Carbon::today()->toDateString())
            ->take($dataAmount)
            ->orderBy("id", "desc")
            ->orWhereIn($regionsCommunesArray)
            ->count();
            
            //$offersCount = Offer::with("user")->where("status", "abierto")->has("user")->count();

            return response()->json(["success" => true, "posts" => $posts, "postsCount" => $postsCount, "dataAmount" => $dataAmount]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "err" => $e->getMessage(), "ln" => $e->getLine(), "msg" => "Ha ocurrido un problema"]);
        }

    }

}
