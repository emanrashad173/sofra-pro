<?php

namespace App\Http\Controllers\Front\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\Comment;
use App\Models\Order;


class MainController extends Controller
{
  //new-order
  public function newOrder($id)
  {
    $model = auth('web-client')->user()->orders()->find($id);
    return view('front.client.new-order',compact('model'));
  }

  //create-order
  public function createOrder(Request $request ,$id)
  {
      $validator = $this->validate($request,[
       'notes' => 'required' ,
       'payment_method_id' => 'required|exists:payment_methods,id'
     ]);

     $order = Order::find($request->id);
     if($order->restaurant->activation == 'deactive')
     {
       return "المطعم مغلق";
     }

      //client
     $orderUpdate = auth('web-client')->user()->orders()->where('state','cart')->update([
       'notes' =>$request->notes,
       'state' => 'pending', // default value
       'address' => auth('web-client')->user()->address,
       'payment_method_id' => $request->payment_method_id
     ]);

     if($order->cost >= $order->restaurant->minimum_order)
     {
       $commission = settings()->commission *$order->cost/100;
       $net = $order->total - $commission;

       $update = $order->update([
         'commission' => $commission ,
         'net' => $net ,
       ]);
     }
     else{
       $order->products()->delete();
       $order->delete();
       return "gfuyfuyfuyf";
     }

     return redirect('home') ;
 }
  //order-current
  public function myOrder()
  {
      $orders = auth()->user()->orders()->whereIn('state' , ['confirmed','accepted','pending'])->paginate(2);
      return view('front.client.client-orders' ,compact('orders'));
  }

  //order-previous
  public function previousOrder()
  {
      $orders = auth()->user()->orders()->whereNotIn('state' , ['pending','accepted','confirmed'])->paginate(2);
      return view('front.client.client-previous-order' ,compact('orders'));
  }

  //delivered-orders
  public function deliverOrder($id)
  {
      $order = auth()->user()->orders()->find($id);
      $order->update(['state'=> 'delivered']);
      return back();
  }

  //declined-orders
  public function declineOrder($id)
  {
      $order = auth()->user()->orders()->find($id);
      $order->update(['state'=> 'declined']);
      return back();
  }

  //comment-create
  public function commentCreate(Request $request)
  {
      $validator = $this->validate($request,[
        'content' => 'required' ,
        'rating'  => 'required|in:1,2,3,4,5',
      ]);
      $avg = auth('web-client')->user()->comments()->avg('rating');
      Restaurant::find($request->id)->update(['rate' => $avg]);
      $comment =auth('web-client')->user()->comments()->create(['content' =>$request->content,
      'rating' => $request->rating,'restaurant_id' => $request->id]);
      return back();
   }

  //addToCart
  public function addToCart($id,Request $request)
  {
     $product = Product::find($id);
     $restaurant = Restaurant::findOrFail($product->restaurant_id);
     // check cart
     $order = auth('web-client')->user()->orders()->where('state','cart')->first();
     if (!$order) {
       $order = auth('web-client')->user()->orders()->create([
         'restaurant_id'=> $product->restaurant_id,
         'state' => 'cart',
         'payment_method_id' => 1
       ]);
     }else{
       if ($order->restaurant_id != $restaurant->id) {
         return 'wrong restaurant';
       }
     }

     $productInCart = $order->products()->where('product_id',$product->id)->first();
     if ($productInCart) {
       $order->products()->updateExistingPivot(
         $product->id ,
         [
           'quantity' => $productInCart->pivot->quantity +1,
           'price_in_order' => ($productInCart->pivot->quantity +1) * $product->price,
           'special_notes' => $request->special_notes
         ]
       );
     }
     else{
       $order->products()->attach([
         $product->id => [
           'quantity' => $request->input('quantity',1),
           'price_in_order' => $request->input('quantity',1) * $product->price,
           'special_notes' => $request->special_notes
         ]
       ]);
     }
     $order->cost += $request->input('quantity',1) * $product->price;
     $order->delivery_cost = $restaurant->delivery_cost;
     $order->total = $order->cost + $order->delivery_cost;
     $order->save();
     return redirect('client/cart');
  }

   //cart-show
   public function cart()
   {
      $order = auth('web-client')->user()->orders()->where('state' ,'cart')->first();
if($order)
  {
       $products = $order->products()->get();

       return view('front.client.cart', compact('products'));
   }
   return view('front.client.cart');
 }

   //removeProduct
   public function removeProduct($id)
   {
       $order =auth('web-client')->user()->orders()->where('state' ,'cart')->first();
       $order->products()->detach($id);
       $productCount = $order->products()->count();
       if($productCount == 0)
       {
            $order->delete();
       }
       return redirect('/restaurant-page/'.$order->restaurant_id);
   }
}
