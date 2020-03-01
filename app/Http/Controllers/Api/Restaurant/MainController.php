<?php

namespace App\Http\Controllers\Restaurant\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Restaurant;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Token;
use App\Models\Client;
use App\Models\Notification;


class MainController extends Controller
{
   //create-product
   public function productCreate(Request $request)
   {
        $validator = validator()->make($request->all(), [
          'name' => 'required',
          'description' => 'required' ,
          'price' => 'required' ,
          'image' => 'required' ,
          'preparation_time' => 'required'
        ]);
        if($validator->fails())
        {
            return apiResponse(0,$validator->errors()->first(),$validator->errors());
        }
        $product =$request->user()->products()->create($request->all());
        return apiResponse(1,'success' ,$product);
   }

    //edit-product
    public function productEdit(Request $request)
    {
        $product =$request->user()->products()->find($request->id);
        $product->update($request->all());
        $product->save();
        return apiResponse(1,'success' ,$product);
    }

    //delete-product
    public function productDelete(Request $request)
    {
       $product =$request->user()->products()->find($request->id);
       $product->delete();
       return apiResponse(1,'success');
    }

    //products
    public function products(Request $request)
    {
        // $restaurant = Restaurant::find($request->id);
        // $products =$request->user()->products()->paginate(5);
        $products = Product::where('restaurant_id' ,$request->user()->id)->paginate(10);
        return apiResponse(1,'success' ,$products);
    }

    //create-offer
    public function offerCreate(Request $request)
    {
         $validator = validator()->make($request->all(), [
           'image' => 'required' ,
           'description' => 'required' ,
           'from_date' => 'required',
           'to_date' => 'required'
         ]);
         if($validator->fails())
         {
             return apiResponse(0,$validator->errors()->first(),$validator->errors());
         }
         $img = $request->file('image');
         $directionPath = public_path().'/uploads/image/offers/';
         $extension = $img->getClientOriginalExtension();
         $name = rand('22222','999999'). '.' . $extension;
         $img->move($directionPath, $name);
         $offer =$request->user()->offers()->create($request->all());
         $offer->image ='uploads/image/offers/'.$name;
         $offer->save();
         return apiResponse(1,'success' ,$offer);
    }

     //edit-offer
     public function offerEdit(Request $request)
     {
         $offer =$request->user()->offers()->find($request->id);
         $offer->update($request->all());
         $offer->save();
         return apiResponse(1,'success' ,$offer);
     }

     //delete-offer
     public function offerDelete(Request $request)
     {
          $product =$request->user()->offers()->find($request->id);
          $product->delete();
          return apiResponse(1,'success');
     }

     //offers
     public function offers(Request $request)
     {
         // $restaurant = Restaurant::find($request->id);
         // $products =$request->user()->products()->paginate(5);
         $offers = Offer::where('restaurant_id' ,$request->user()->id)->paginate(10);
         return apiResponse(1,'success' ,$offers);
     }

     //myorders
     public function myOrders(Request $request)
     {
       $order = $request->user()->orders()->where(function($order) use($request){
         if($request->state =='pending')
         {
           $order->where('state' , '=' ,'pending');
         }
         if($request->state =='current')
         {
           $order->where('state' , '=' ,'accepted');
         }
         if($request->state =='completed')      // delivered declined rejected confirmed
         {
           $order->whereNotIn('state' , ['pending','accepted']);
         }
       })->latest()->paginate(10);

       return apiResponse(1,'success' , $order);
     }

     //order-details
     public function orderDetails(Request $request)
     {
       $order = $request->user()->orders()->where('id' , $request->id)->get();
       return apiResponse(1,'success' , $order);
     }

     //accept-orders
     public function acceptOrder(Request $request)
     {
       $order = $request->user()->orders()->find($request->order_id);
       if(!$order)
       {
         return apiResponse(0,'لايوجد طلب');
       }
       if($order->state != 'pending')
       {
         return apiResponse(0,'لا يمكن طلب قبول');
       }
       $order->update(['state'=> 'accepted']);
       //notifications
       $client = Client::find($order->client_id);
       $notification =$client->notifications()->create([
         'title' => 'تم توصيل طلب' ,
         'content' => ' تم توصيل طلبك من المطعم'.$request->user()->name,
         'order_id' => $order->id,
       ]);

       $androidTokens = $client->tokens()->where('type','android')->pluck('token')->toArray();
       $iosTokens = $client->tokens()->where('type','ios')->pluck('token')->toArray();
       $title = $notification->title;
       $body = $notification->content;
       $data = [
         'user_type' => 'client',
         'action' =>'confirm-order',
         'order_id' => $order->id,
       ];
       info(json_encode($data));
       if(count($androidTokens)){
         $send = notifyByFirebase($title, $body ,$androidTokens,$data,true);
         info("firebase result: " .$send);
       }
       if(count($iosTokens)){
         $send = notifyByFirebase($title, $body ,$iosTokens,$data,true);
         info("firebase result: " .$send);
       }

       return apiResponse(1,'تم قبول الطلب');
     }

     //confirm-orders
     public function confirmOrder(Request $request)
     {
       $order = $request->user()->orders()->find($request->order_id);
       if(!$order)
       {
         return apiResponse(0,'لايوجد طلب');
       }
       if($order->state !='accepted')
       {
         return apiResponse(0,'لا يمكن طلب تاكيد');
       }
       $order->update(['state'=> 'confirmed']);
       //notifications
       $client = Client::find($order->client_id);
       $notification =$client->notifications()->create([
         'title' => 'تم تاكيد طلبك بنجاح' ,
         'content' => ' تم تاكيد طلبك بنجاح من المطعم'.$request->user()->name,
         'order_id' => $order->id,
       ]);

       $androidTokens = $client->tokens()->where('type','android')->pluck('token')->toArray();
       $iosTokens = $client->tokens()->where('type','ios')->pluck('token')->toArray();
       $title = $notification->title;
       $body = $notification->content;
       $data = [
         'user_type' => 'client',
         'action' =>'confirm-order',
         'order_id' => $order->id,
       ];
       info(json_encode($data));
       if(count($androidTokens)){
         $send = notifyByFirebase($title, $body ,$androidTokens,$data,true);
         info("firebase result: " .$send);
       }
       if(count($iosTokens)){
         $send = notifyByFirebase($title, $body ,$iosTokens,$data,true);
         info("firebase result: " .$send);
       }

       return apiResponse(1,'تم تاكيد الطلب');
     }

     //reject-orders
     public function rejectOrder(Request $request)
     {
       $order = $request->user()->orders()->find($request->order_id);
       if(!$order)
       {
         return apiResponse(0,'لايوجد طلب');
       }
       if($order->state != 'pending')
       {
         return apiResponse(0,'لا يمكن طلب رفض');
       }
       $order->update(['state'=> 'rejected']);
       //notifications
       $client = Client::find($order->client_id);
       $notification =$client->notifications()->create([
         'title' => 'تم رفض طلب الاوردر ' ,
         'content' => ' تم رفض طلبك الاوردر من المطعم'.$request->user()->name,
         'order_id' => $order->id,
       ]);

       $androidTokens = $client->tokens()->where('type','android')->pluck('token')->toArray();
       $iosTokens = $client->tokens()->where('type','ios')->pluck('token')->toArray();
       $title = $notification->title;
       $body = $notification->content;
       $data = [
         'user_type' => 'client',
         'action' =>'confirm-order',
         'order_id' => $order->id,
       ];
       info(json_encode($data));
       if(count($androidTokens)){
         $send = notifyByFirebase($title, $body ,$androidTokens,$data,true);
         info("firebase result: " .$send);
       }
       if(count($iosTokens)){
         $send = notifyByFirebase($title, $body ,$iosTokens,$data,true);
         info("firebase result: " .$send);
       }


       return apiResponse(1,'تم رفض الطلب');
     }

     //notifications
     public function notification(Request $request)
     {
       $notification = $request->user()->notifications()->latest()->paginate(5);
       return apiResponse(1,'success' ,$notification);
     }

     //commission
     public function commission(Request $request)
     {

       $sales = $request->user()->orders()->where('state','delivered')->sum('cost');
       $commission = settings()->commission * $sales / 100;
       $received = $request->user()->payment()->sum('received_money');
       $remain = $commission -  $received;
       $data =[
         'sales' => $sales ,
         'commission' => $commission,
         'received'  =>$received,
         'remain' =>$remain
       ];
       return apiResponse(1,'success' ,$data);
     }


}
