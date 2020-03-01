<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\District;
use App\Models\Setting;
use App\Models\Contact;
use App\Models\Category;
use App\Models\PaymentMethod;
use App\Models\Restaurant;
use App\Models\Offer;
use App\Models\Comment;
use App\Models\Product;


class MainController extends Controller
{
    //cities
    public function cities()
    {
        $cities = City::all();
        return apiResponse(1,'success',$cities);
    }

    //districts
    public function districts(Request $request)
    {
        $districts = District::where(function($query) use($request){
          if($request->has('city_id'))
          {
            $query->where('city_id',$request->city_id);
          }
        })->get();
        return apiResponse(1 , 'success',$districts);
    }

    //categories
    public function categories()
    {
          $categories= Category::all();
          return apiResponse(1 ,'success', $categories);
    }

    //payment-methods
    public function paymentMethods()
    {
        $payments= PaymentMethod::all();
        return apiResponse(1 ,'success', $payments);
    }

   //contactUs
   public function contactUs(Request  $request)
   {
       $validator = validator()->make($request->all(), [
          'name' => 'required',
          'phone' => 'required',
          'email' => 'required',
          'message' => 'required',
          'type' => 'required',
       ]);

      if($validator->fails())
      {
          return apiResponse(0, $validator->errors()->first() ,  $validator->errors());
      }

      $contact = Contact::create($request->all());
      $contact->save();

      return apiResponse(1, 'success');
    }

   //settings
   public function settings()
   {
       $settings= Setting::first();
       return apiResponse(1 ,'success', $settings);
   }

   //restaurants
   public function restaurants(Request $request)
   {
       $restaurants = Restaurant::with('district.city')->
       where(function($restaurant) use($request){
              if ($request->has('city_id')) {
                 $restaurant->whereHas('district',function($district) use($request){
                   $district->where('city_id',$request->city_id);
                 });
              }
              if ($request->has('keyword')) {
                $restaurant->where(function($query) use($request){
                  $query->where('name','like','%'.$request->keyword.'%');
                });
              }
            })->paginate(5);
       return apiResponse(1,'success',$restaurants);
   }

   //restaurant
   public function restaurant(Request $request)
   {
       $restaurant = Restaurant::find($request->id);
       return apiResponse(1,'success',$restaurant);
   }

   //listRestaurantProducts
   public function listRestaurantProducts(Request $request)
   {
       $products = Product::where('restaurant_id',$request->id)->paginate(5);
       return apiResponse(1,'success',$products);
   }

   //listRestaurantComments
   public function listRestaurantComments(Request $request)
   {
       $comments = Comment::where('restaurant_id',$request->id)->paginate(5);
       return apiResponse(1,'success',$comments);
   }

   //offers
   public function offers()
   {
       $offers = Offer::latest()->paginate(5);
       return apiResponse(1,'success',$offers);
   }

   //offer
   public function offer(Request $request)
   {
       $offer = Offer::find($request->id);
       return apiResponse(1,'success',$offer);
   }


}
