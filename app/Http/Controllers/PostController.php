<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostStoreRequest;
use Intervention\Image\Facades\Image;
use App\Post;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\DiscountDay;
use App\SecondaryImage;
use App\Purchase;
use App\PostProduct;
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
            $startDate = Carbon::parse($request->saleDate)->subDays(7);
            $dueDate = Carbon::parse($request->saleDate)->addDays(7);
            $user = JWTAuth::parseToken()->toUser();

            if($startDate->greaterThanOrEqualTo($now)){
                
                if($request->type == 1){
                    if(Post::where("start_date",$startDate)->where("commune_id", $user->commune_id)->where("type",$request->type)->count() >= 30){
                        return response()->json(["success" => false, "msg" => "Se ha superado la cantidad de publicaciones para este día, por favor seleccione otra fecha de venta"]);
                    }
                }

                else if($request->type == 2){
                    if(Post::where("start_date",$startDate)->where("commune_id", $user->commune_id)->where("type",$request->type)->count() >= 15){
                        return response()->json(["success" => false, "msg" => "Se ha superado la cantidad de publicaciones para este día, por favor seleccione otra fecha de venta"]);
                    }
                }

                if($request->type == 3){
                    if(Post::where("start_date",$startDate)->where("commune_id", $user->commune_id)->where("type",$request->type)->count() >= 5){
                        return response()->json(["success" => false, "msg" => "Se ha superado la cantidad de publicaciones para este día, por favor seleccione otra fecha de venta"]);
                    }
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
                $post->category_id = $request->categoryId;
                $post->commune_id = $user->commune_id;
                $post->sale_date = $saleDate->format('y-m-d');
                $post->start_date = $startDate->format('y-m-d');
                $post->due_date = $dueDate->format('y-m-d');
                $post->save();

                foreach($request->promos as $promo){

                    $imageData = $promo["picture"];
                    $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
                    Image::make($promo["picture"])->save(public_path('images/posts/products/').$fileName, 50);

                    $postProduct = new PostProduct;
                    $postProduct->post_id = $post->id;
                    $postProduct->amount = $promo["amount"];
                    $postProduct->title = $promo["title"];
                    $postProduct->description = $promo["description"];
                    $postProduct->price = $promo["price"];
                    $postProduct->image = $fileName;
                    $postProduct->save();

                }

                $discount = new DiscountDay;
                $discount->post_id = $post->id;
                $discount->date = Carbon::parse($request->startDate)->addDay();
                $discount->discount = $request->discount1;
                $discount->save();

                $discount = new DiscountDay;
                $discount->post_id = $post->id;
                $discount->date = Carbon::parse($request->startDate)->addDays(2);
                $discount->discount = $request->discount2;
                $discount->save();

                $discount = new DiscountDay;
                $discount->post_id = $post->id;
                $discount->date = Carbon::parse($request->startDate)->addDays(3);
                $discount->discount = $request->discount3;
                $discount->save();

                $discount = new DiscountDay;
                $discount->post_id = $post->id;
                $discount->date = Carbon::parse($request->startDate)->addDays(4);
                $discount->discount = $request->discount4;
                $discount->save();

                $discount = new DiscountDay;
                $discount->post_id = $post->id;
                $discount->date = Carbon::parse($request->startDate)->addDays(5);
                $discount->discount = $request->discount5;
                $discount->save();

                $discount = new DiscountDay;
                $discount->post_id = $post->id;
                $discount->date = Carbon::parse($request->startDate)->addDays(6);
                $discount->discount = $request->discount6;
                $discount->save();

                $discount = new DiscountDay;
                $discount->post_id = $post->id;
                $discount->date = Carbon::parse($request->startDate)->addDays(7);
                $discount->discount = $request->discount7;
                $discount->save();


                /*for($i = 7; $i > 0; $i--){

                    $discount = new DiscountDay;
                    $discount->post_id = $post->id;
                    $discount->date = Carbon::parse($request->saleDate)->subDays($i);    
                    $discountPercent = ($request->maxDiscount / 7) * $i;
                    if($discountPercent < 5){
                        $discount->discount = 5;
                    }else{
                        $discount->discount = $discountPercent;
                    }
                    $discount->save();
                }*/

                return response()->json(["success" => true, "msg" => "Tu publicación será visible a partir del ".$startDate->format('y-m-d')]);

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

        $post = Post::with('user', 'discountDays', 'category', 'commune', 'products')->where("id", $id)->first();
        $now = Carbon::now();
        $saleDate = Carbon::parse($post->sale_date);
        $startDate = Carbon::parse($post->start_date);
        $dueDate = Carbon::parse($post->due_date);
        $showBuyButton = false;
        CarbonPeriod::setLocale('es');
        
        $promoPeriod = CarbonPeriod::create($post->start_date, $saleDate->subDay()->format("Y-m-d"));
        $salePeriod = CarbonPeriod::create($saleDate->addDays(2)->format("Y-m-d"), $dueDate->format("Y-m-d"));

        if($startDate->greaterThanOrEqualTo($now) && $dueDate->lessThanOrEqualTo($now) ){

            $showBuyButton = true;

        }else{

            $showBuyButton = false;

        }



        return view("user.posts.show", ["post" => $post, "showBuyButton" => $showBuyButton, "todaysDate" => $now,"promoPeriod" => $promoPeriod->toArray(), "salePeriod" => $salePeriod->toArray()]);

    }

}
