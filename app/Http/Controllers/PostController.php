<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostStoreRequest;
use Intervention\Image\Facades\Image;
use App\Post;
use Carbon\Carbon;
use App\DiscountDay;
use App\SecondaryImage;
use App\Purchase;
use JWTAuth;

class PostController extends Controller
{
    function index(){

        return view("user.posts.index");

    }
    
    function store(PostStoreRequest $request){

        try{
            
            $imageData = $request->get('main_image');
            $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
            Image::make($request->get('main_image'))->save(public_path('images/posts/').$fileName, 50);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Hubo un error al cargar la imagen", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }


        try{

            $now = Carbon::now();
            $saleDate = Carbon::parse($request->saleDate);
            $startDate = Carbon::parse($request->saleDate)->subDays(6);
            $dueDate = Carbon::parse($request->saleDate)->addDays(6);
            $user = JWTAuth::parseToken()->toUser();

            if($startDate->greaterThanOrEqualTo($now)){
 
                if(Post::where("start_date",$startDate)->where("commune_id", $user->location_id)->count() >= 40){
                    return response()->json(["success" => false, "msg" => "Se ha superado la cantidad de publicaciones para este día, por favor seleccione otra fecha de venta"]);
                }

            }else{

                return response()->json(["success" => false, "msg" => "Debe existir un mínimo de 7 días entre la fecha de venta y la fecha actual"]);

            }



            if($startDate->greaterThanOrEqualTo($now)){

                

                $post = new Post;
                $post->type = $request->type;
                $post->user_id = $user->id;
                $post->title = $request->title;
                $post->description = $request->description;
                $post->image = $fileName;
                $post->amount = $request->amount;
                $post->price = $request->price;
                $post->category_id = $request->categoryId;
                $post->commune_id = $user->location_id;
                $post->sale_date = $saleDate->format('y-m-d');
                $post->start_date = $startDate->format('y-m-d');
                $post->due_date = $dueDate->format('y-m-d');
                $post->save();

                if($request->get('image2')){
                    $this->processImage('image2', $request, $post->id);
                }
        
                if($request->get('image3')){
                    $this->processImage('image3', $request, $post->id);
                }
        
                if($request->get('image4')){
                    $this->processImage('image4', $request, $post->id);
                }
        
                if($request->get('image5')){
                    $this->processImage('image5', $request, $post->id);
                }

                $discount = new DiscountDay;
                $discount->post_id = $post->id;
                $discount->date = Carbon::parse($request->saleDate)->subDays(6);
                $discount->discount = $request->discount1;
                $discount->save();

                $discount = new DiscountDay;
                $discount->post_id = $post->id;
                $discount->date = Carbon::parse($request->saleDate)->subDays(5);
                $discount->discount = $request->discount2;
                $discount->save();

                $discount = new DiscountDay;
                $discount->post_id = $post->id;
                $discount->date = Carbon::parse($request->saleDate)->subDays(4);
                $discount->discount = $request->discount3;
                $discount->save();

                $discount = new DiscountDay;
                $discount->post_id = $post->id;
                $discount->date = Carbon::parse($request->saleDate)->subDays(3);
                $discount->discount = $request->discount4;
                $discount->save();

                $discount = new DiscountDay;
                $discount->post_id = $post->id;
                $discount->date = Carbon::parse($request->saleDate)->subDays(2);
                $discount->discount = $request->discount5;
                $discount->save();

                $discount = new DiscountDay;
                $discount->post_id = $post->id;
                $discount->date = Carbon::parse($request->saleDate)->subDays(1);
                $discount->discount = $request->discount6;
                $discount->save();

                $discount = new DiscountDay;
                $discount->post_id = $post->id;
                $discount->date = Carbon::parse($request->saleDate);
                $discount->discount = $request->discount7;
                $discount->save();

                return response()->json(["success" => true, "msg" => "Publicación realizada"]);

            }else{

                return response()->json(["success" => false, "msg" => "Deben existir al menos 7 días antes de la fecha de inicio"]);

            }

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function processImage($imageField, $request, $postId){
        try{
            
            $imageData = $request->get($imageField);
            $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
            Image::make($request->get('image'))->save(public_path('images/posts/').$fileName, 50);

            $secondaryImage = new SecondaryImage;
            $secondaryImage->image = $fileName;
            $secondaryImage->post_id = $postId;
            $secondaryImage->save();

            //return $fileName;

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Hubo un error al cargar la imagen", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }
    }

    function adminIndex(){
        return view("admin.posts.index");
    }

    function adminFetch($page = 1){

        try{

            $skip = ($page-1) * 20;

            $posts = Post::with("user")->skip($skip)->take(20)->orderBy('id', 'desc')->get();
            $postsCount = Post::with("user")->count();

            return response()->json(["success" => true, "posts" => $posts, "postsCount" => $postsCount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function adminDelete(Request $request){
        
        try{

            $post = Post::where("id", $request->id)->first();
            $post->delete();

            return response()->json(["success" => true, "msg" => "Publicación eliminada"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function checkActiveReservations(Request $request){

        try{

            $user = JWTAuth::parseToken()->toUser();
            $purchases = Purchase::with('payments')->where('user_id', $user->id)->where('is_payment_complete', 0)->where('post_id', $request->id)->get();
            $activeReservations = false;

            foreach($purchases as $purchase){

                foreach($purchase->payments as $payment){

                    if($payment->payment_type == "reservation"){
                        $activeReservations = true;
                    }

                }

            }

            return response()->json(["success" => true, "activeReservations" => $activeReservations]);


        }catch(\Exception $e){

            return response()->json(["success" => false, "Error en el servidor"]);

        }

    }

    function checkSaleDate(Request $request){
        try{

            $now = Carbon::now();
            $saleDate = Carbon::parse($request->saleDate);
            $startDate = Carbon::parse($request->saleDate)->subDays(6);
            $dueDate = Carbon::parse($request->saleDate)->addDays(6);

            if($startDate->greaterThanOrEqualTo($now)){

                return response()->json(["success" => true]);

            }else{

                return response()->json(["success" => false]);

            }

        }catch(\Exception $e){

            return response()->json(["success" => false, "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }
    }

    function show($id){

        $post = Post::with('user', 'discountDays', 'category', 'commune')->where("id", $id)->first();
        $now = Carbon::now()->addDays(5);
        $saleDate = Carbon::parse($post->saleDate);
        $startDate = Carbon::parse($post->saleDate)->subDays(6);
        $dueDate = Carbon::parse($post->saleDate)->addDays(6);
        $showBuyButton = false;

        if($startDate->greaterThanOrEqualTo($now) && $dueDate->lessThanOrEqualTo($now) ){

            $showBuyButton = true;

        }else{

            $showBuyButton = false;

        }

        return view("user.posts.show", ["post" => $post, "showBuyButton" => $showBuyButton, "todaysDate" => $now]);

    }

}
