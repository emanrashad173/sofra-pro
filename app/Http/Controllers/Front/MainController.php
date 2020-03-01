<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Contact;
use App\Models\Comment;





class MainController extends Controller
{

      public function home(Request $request)
      {
        $restaurants = Restaurant::where('activation','active')->where(function($query) use($request)
        {
          if ($request->input('district_id')){
            $query->where('district_id',$request->district_id);
          }
          if($request->input('search_by_name')){
            $query->where(function($query)use($request){
              $query->where('name' ,'like' ,'%' .$request->search_by_name. '%');
            });
          }
        })->paginate(6);
        return view('front.home',compact('restaurants'));
      }


      //offers
      public function offers()
      {
          $offers = Offer::latest()->paginate(4);
          return view('front.general-offers', compact('offers'));
      }

      //offer
      public function offer($id)
      {
          $offer = Offer::find($id);
          return apiResponse(1,'success',$offer);
      }

      //listRestaurantProducts
      public function restaurantProducts($id)
      {
          $products = Product::where('restaurant_id',$id)->paginate(9);
          return view('front.general-restaurant-page',compact('products'));
      }


      //productShow
      public function productShow($id)
      {
        $product = Product::find($id);
        $products =Product::where('restaurant_id',$product->restaurant_id)->paginate(9);
        return view('front.product-show',compact('product','products'));
      }

    //comments
    public function comments($id)
    {
      $comments = Comment::where('restaurant_id',$id)->latest()->paginate(6);
      return view('front.client.comments' ,compact('comments'));
    }

    //contact
    public function contact(Contact $model)
    {
      return view('front.contact-us',compact('model'));
    }

    //contactSave
    public function contactSave(Request $request)
    {
      $validator = $this->validate($request,[
         'name' => 'required',
         'phone' => 'required',
         'email' => 'required|email',
         'message' => 'required',
         'type' => 'required|in:suggestion,complaint,inquiry',

        ]);

     $contact = Contact::create($request->all());

     return redirect('/home');
    }

}
