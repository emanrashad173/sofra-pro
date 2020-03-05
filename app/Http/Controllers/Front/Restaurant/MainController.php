<?php

namespace App\Http\Controllers\Front\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Restaurant;



class MainController extends Controller
{

  //new- product
  public function newProduct()
  {
    return view('front.restaurant.add-product');
  }

  //create-product
  public function productCreate(Request $request)
  {
       $validator = $this->validate($request,[
         'name' => 'required',
         'description' => 'required' ,
         'price' => 'required' ,
         'image' => 'required|image' ,
         'preparation_time' => 'required'
       ]);

       $img = $request->file('image');
       $directionPath = public_path().'/uploads/image/products/';
       $extension = $img->getClientOriginalExtension();
       $name = rand('22222','999999'). '.' . $extension;
       $img->move($directionPath, $name);
       $product =auth('web-restaurant')->user()->products()->create($request->all());
       $product->image ='uploads/image/products/'.$name;
       $product->save();

       return redirect('products');
  }

  //edit- product
  public function editProduct($id)
  {
    $model = auth('web-restaurant')->user()->products()->find($id);
    return view('front.restaurant.edit-product',compact('model'));
  }

  //update-product
  public function productUpdate(Request $request,$id)
  {
      $product =auth('web-restaurant')->user()->products()->find($id);
      $product->update($request->all());
      $product->save();
      return redirect('products');
  }

  //product-delete
  public function productDelete($id)
  {
       $product =auth('web-restaurant')->user()->products()->find($id);
       $product->delete();
       return back();
  }

  //new- offer
  public function newOffer()
  {
    return view('front.restaurant.add-offer');
  }

  //create-offer
  public function offerCreate(Request $request)
  {
       $validator = $this->validate($request,[
         'name' => 'required' ,
         'image' => 'required|image' ,
         'description' => 'required' ,
         'from_date' => 'required',
         'to_date' => 'required'
       ]);

       $img = $request->file('image');
       $directionPath = public_path().'/uploads/image/offers/';
       $extension = $img->getClientOriginalExtension();
       $name = rand('22222','999999'). '.' . $extension;
       $img->move($directionPath, $name);
       $offer =$request->user()->offers()->create($request->all());
       $offer->image ='uploads/image/offers/'.$name;
       $offer->save();
       return redirect('offers');
  }

  //edit- offer
  public function editOffer($id)
  {
    $model = auth('web-restaurant')->user()->offers()->find($id);
    return view('front.restaurant.edit-offer',compact('model'));
  }

  //update-offer
  public function offerUpdate(Request $request,$id)
  {
      $offer =auth('web-restaurant')->user()->offers()->find($id);
      $offer->update($request->all());
      $offer->save();
      return redirect('offers');
  }

  //offer-delete
  public function offerDelete($id)
  {
       $offer =auth('web-restaurant')->user()->offers()->find($id);
       $offer->delete();
       return back();
  }

  //offers
  public function offers()
  {
      $offers = auth('web-restaurant')->user()->offers()->latest()->paginate(4);
      return view('front.restaurant.offers-restaurant',compact('offers'));
  }

  //products
  public function products()
  {
      $products = auth('web-restaurant')->user()->products()->latest()->paginate(9);
      return view('front.restaurant.products-restaurant',compact('products'));
  }

  //order-news
  public function newOrder(){
    $orders = auth('web-restaurant')->user()->orders()->where('state' , '=' ,'pending')->latest()->paginate(2);
    return view('front.restaurant.order-news' ,compact('orders'));
  }

  //order-current
  public function currentOrder(){
    $orders = auth('web-restaurant')->user()->orders()->where('state' , '=' ,'accepted')->latest()->paginate(2);
    return view('front.restaurant.order-current' ,compact('orders'));
  }

  //order-previous
  public function previousOrder(){
    $orders = auth('web-restaurant')->user()->orders()->whereNotIn('state' , ['pending','accepted'])->latest('id')->paginate(20);
    return view('front.restaurant.order-previous' ,compact('orders'));
  }

  //restaurant accept-orders
  public function acceptOrder($id)
  {
    $order = auth('web-restaurant')->user()->orders()->find($id);
    $order->update(['state'=> 'accepted']);
    return back();
  }

  //restaurant confirm-orders
  public function confirmOrder($id)
  {
    $order = auth('web-restaurant')->user()->orders()->find($id);
    $order->update(['state'=> 'confirmed']);
    return back();
  }

  //restaurant reject-orders
  public function rejectOrder($id)
  {
    $order = auth('web-restaurant')->user()->orders()->find($id);
    $order->update(['state'=> 'rejected']);
    return back();
  }
}
