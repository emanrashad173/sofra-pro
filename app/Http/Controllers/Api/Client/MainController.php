<?php

namespace App\Http\Controllers\Client\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Restaurant;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Token;
use App\Models\Client;
use App\Models\Notification;


class MainController extends Controller
{
    //comment-create
    public function commentCreate(Request $request)
    {
          $validator = validator()->make($request->all(),[
            'restaurant_id' => 'required|exists:restaurants,id',
            'content' => 'required' ,
            'rating'  => 'required|in:1,2,3,4,5'
          ]);

          if($validator->fails())
          {
              return apiResponse(0,$validator->errors()->first(),$validator->errors());
          }
          $avg = $request->user()->comments()->avg('rating');
          Restaurant::find($request->restaurant_id)->update(['rate' => $avg]);
          $comment =$request->user()->comments()->create($request->all());
          return apiResponse(1,'success' ,$comment);
     }

    //create-order
    public function orderCreate(Request $request)
    {
          $validator = validator()->make($request->all(),[
           'restaurant_id' => 'required|exists:restaurants,id',
           'products.*.product_id' => 'required|exists:products,id',
           'products.*.quantity' => 'required',
           'address' => 'required' ,
           'payment_method_id' => 'required|exists:payment_methods,id'
         ]);

         if($validator->fails())
         {
             return apiResponse(0,$validator->errors()->first(),$validator->errors());
         }

         $restaurant = Restaurant::find($request->restaurant_id);
         if($restaurant->activation == 'deactive')
         {
           return apiResponse(0,'هذا المطعم غير متاح في الوقت الحالي');
         }

          //client
         $order = $request->user()->orders()->create([
           'restaurant_id' => $request->restaurant_id,
           'notes' =>$request->notes,
           'state' => 'pending', // default value
           'address' => $request->address,
           'payment_method_id' => $request->payment_method_id
         ]);

         $cost = 0;
         $delivery_cost= $restaurant->delivery_cost;

         foreach($request->products as $pro)
         {
           $product = Product::find($pro['product_id']);
           $readyProduct = [
             $pro['product_id'] =>[
               'quantity' => $pro['quantity'],
               'price_in_order' => $product->price,
               'special_notes' =>(isset($pro['special_notes'])) ? $pro['special_notes']: ''
             ]
           ];
           $order->products()->attach($readyProduct);
           $cost +=($product->price * $pro['quantity']);
         }

         if($cost >= $restaurant->minimum_order)
         {
           $total=$cost + $delivery_cost;
           $commission = settings()->commission *$cost/100;
           $net = $total - $commission;

           $update = $order->update([
             'cost' => $cost ,
             'delivery_cost' => $delivery_cost ,
             'total' => $total ,
             'commission' => $commission ,
             'net' => $net ,
           ]);
           //notifications
           $notification = $restaurant->notifications()->create([
             'title' => 'لديك طلب جديد' ,
             'content' => 'لديك طلب جديد من العميل '.$request->user()->name,
             'order_id' => $order->id,
           ]);

           $androidTokens = $restaurant->tokens()->where('type','android')->pluck('token')->toArray();
           $iosTokens = $restaurant->tokens()->where('type','ios')->pluck('token')->toArray();
           $title = $notification->title;
           $body = $notification->content;
           $data = [
             'user_type' => 'restaurant',
             'action' =>'new-order',
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

          $data=[
            'order' =>$order->fresh()->load('products')
          ];
          return apiResponse(1,'success' ,$data);
         }
         else{
           $order->products()->delete();
           $order->delete();
           return apiResponse(0,'الطلب لابد ان يكون اقل من '.$restaurant->minimum_order.'ريال ');
         }
    }

    //client orders
    public function orders(Request $request)
    {
      $order = $request->user()->orders()->where(function($order) use($request){

        if($request->state =='current')
        {
          $order->whereIn('state' , ['pending','accepted','confirmed']);
        }
        if($request->state =='previous')      //rejected delivered declined
        {
          $order->whereNotIn('state' , ['pending','accepted','confirmed']);
        }
      })->latest()->paginate(10);

      return apiResponse(1,'success' , $order);
    }

    //delivered-orders
    public function deliveredOrder(Request $request)
    {
      $order = $request->user()->orders()->find($request->order_id);
      if(!$order)
      {
        return apiResponse(0,'لايوجد طلب');
      }
      if($order->state !='confirmed')
      {
        return apiResponse(0,'لا يمكن طلب تاكيد');
      }
      $order->update(['state'=> 'delivered']);
      //notifications
      $restaurant = Restaurant::find($order->restaurant_id);

      $notification = $restaurant->notifications()->create([
        'title' => 'تم استلام الاوردر' ,
        'content' => 'تم استلام الاوردر الي العميل'.$request->user()->name,
        'order_id' => $order->id,
      ]);
      $androidTokens = $restaurant->tokens()->where('type','android')->pluck('token')->toArray();
      $iosTokens = $restaurant->tokens()->where('type','ios')->pluck('token')->toArray();
      $title = $notification->title;
      $body = $notification->content;
      $data = [
        'user_type' => 'restaurant',
        'action' =>'delivered-order',
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
      return apiResponse(1,'تم استلام الاوردر');
    }
    //declined-orders
    public function declinedOrder(Request $request)
    {
      $order = $request->user()->orders()->find($request->order_id);
      if(!$order)
      {
        return apiResponse(0,'لايوجد طلب');
      }
      if($order->state !='confirmed')
      {
        return apiResponse(0,'لا يمكن طلب تاكيد');
      }
      $order->update(['state'=> 'declined']);
      //notifications
      $restaurant = Restaurant::find($order->restaurant_id);

      $notification = $restaurant->notifications()->create([
        'title' => 'تم رفض الاوردر' ,
        'content' => 'تم رفض الاوردر من العميل'.$request->user()->name,
        'order_id' => $order->id,
      ]);

      $androidTokens = $restaurant->tokens()->where('type','android')->pluck('token')->toArray();
      $iosTokens =  $restaurant->tokens()->where('type','ios')->pluck('token')->toArray();
      $title = $notification->title;
      $body = $notification->content;
      $data = [
        'user_type' => 'restaurant',
        'action' =>'declined-order',
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
      return apiResponse(1,'تم رفض الطلب من العميل');
    }

    //order-details
    public function orderShow(Request $request)
    {
      $order = $request->user()->orders()->get()->last();
      return apiResponse(1,'success' ,$order);
    }

    //notifications
    public function notification(Request $request)
    {
      $notification = $request->user()->notifications()->latest()->paginate(5);
      return apiResponse(1,'success' ,$notification);
    }

}
