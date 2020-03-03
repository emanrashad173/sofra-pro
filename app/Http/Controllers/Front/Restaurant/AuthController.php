<?php

namespace App\Http\Controllers\Front\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;
use App\Models\Restaurant;

class AuthController extends Controller
{
    //register
    public function register()
    {
      return view('front.restaurant.register-restaurant');
    }

    //registerSave
    public function registerSave(Request $request)
    {
      $validator = $this->validate($request,[
        'name'=>'required',
        'phone'=>'required|digits:11',
        'email'=>'required|unique:restaurants',
        'password'=>'required|confirmed',
        'category_id'=>'required',
        'district_id'=>'required',
        'minimum_order' =>'required' ,
        'delivery_cost' =>'required' ,
        'phone_contact' =>'required|digits:11' ,
        'whats_num' =>'required|digits:11' ,
        'image' =>'required|image' ,
      ]);

      $request->merge(['password'=>bcrypt($request->password)]);
      $img = $request->file('image');
      $directionPath = public_path().'/uploads/image/restaurants/';
      $extension = $img->getClientOriginalExtension();
      $name = rand('22222','999999'). '.' . $extension;
      $img->move($directionPath, $name);
      $restaurant=Restaurant::create($request->all());
      $restaurant->image ='uploads/image/restaurants/'.$name;
      $restaurant->api_token = Str::random(60);
      $restaurant->save();
      return redirect('products');
     }


     //login
     public function login(Restaurant $model)
     {
        return view('front.restaurant.login-restaurant',compact('model'));
     }

     //loginSave
     public function loginSave(Request $request)
     {
       $validator = $this->validate($request,[
          'email'=>'required|email',
          'password'=>'required'
       ]);

       $restaurant=Restaurant::where('email',$request->email)->first();
       if($restaurant)
       {
         if(Hash::check($request->password,$restaurant->password))
         {
           auth('web-restaurant')->login($restaurant);
           return redirect('/restaurant/products');
         }
         else{
           return redirect()->back();
         }
       }
       else{
         return redirect()->back() ;
       }
     }

     //logout
      public function logout(Request $request)
      {
        auth('web-restaurant')->logout();
        return redirect('/home');
      }

     //resetPassword
     public function resetPassword(Restaurant $model)
     {
      return view('front.restaurant.reset-password-restaurant',compact('model'));
     }

     //passwordReset
     public function passwordReset(Request $request)
     {
        $user = Restaurant::where('email', $request->email)->first();

        if($user)
        {
          $code = rand(1111,9999);
          $update = $user->update(['pin_code' => $code]);
          if($update)
          {
            Mail::to($user->email)
                ->bcc("eman123456eman123@gmail.com")
                ->send(new ResetPassword($code));

            return redirect('/new-password-restaurant');
          }
          else
          {
            return redirect()->back();
          }
        }
        else
        {
          return redirect()->back();
        }
    }

    //newPassword
    public function newPassword(Restaurant $model)
    {
      return view('front.restaurant.new-password-restaurant',compact('model'));
    }

    //passwordChanged
    public function passwordChanged (Request $request)
    {
      $validator = $this->validate($request,[
        'pin_code' =>'required',
        'email' => 'required|email',
        'password'=> 'required|confirmed'
      ]);

      $user = Restaurant::where('pin_code' ,$request->pin_code)->where('pin_code' ,'!=',0)
      ->where('email',$request->email)->first();
      if ($user)
      {
          $user->password = bcrypt($request->password);
          $user->pin_code = null ;
          $user->save();
          return redirect('products');

       }
       else{
         return redirect()->back();
       }
    }

    //profile
    public function profile(Restaurant $model)
    {
       return view('front.restaurant.profile-restaurant',compact('model'));
    }

    //profileSet
    public function profileSet(Request $request)
    {
        $user =auth('web-restaurant')->user();
        $user->update($request->all());
        $user->save();
        return redirect('products');
    }


}
