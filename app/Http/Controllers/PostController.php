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

            if($startDate->greaterThanOrEqualTo($now)){

                $user = JWTAuth::parseToken()->toUser();

                $post = new Post;
                $post->user_id = $user->id;
                $post->title = $request->title;
                $post->description = $request->description;
                $post->image = $fileName;
                $post->amount = $request->amount;
                $post->price = $request->price;
                $post->category_id = $request->categoryId;
                $post->location_id = $user->location_id;
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

}
