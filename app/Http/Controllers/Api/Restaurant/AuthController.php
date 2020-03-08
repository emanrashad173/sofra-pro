<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;
use App\Models\Restaurant;
use App\Models\Token;
use JWTAuth;
use JWTFactory;
use Response;
use Config;


class AuthController extends Controller
{
  public function __construct()
    {
        Auth::shouldUse('api-restaurant');
    }

    //Register
    public function register(Request $request)
    {
        $validator = validator()->make($request->all(),[
          'name'=>'required',
          'phone'=>'required|digits:11',
          'email'=>'required|unique:restaurants',
          'password'=>'required|confirmed',
          'district_id'=>'required',
          'minimum_order' =>'required' ,
          'delivery_cost' =>'required' ,
          'whats_num' =>'required' ,
          'phone_contact' =>'required' ,
          'image' =>'required|image' ,
          'activation' =>'required'
        ]);
  //
        if($validator->fails())
        {
            return apiResponse(0,$validator->errors()->first(),$validator->errors());
        }

        $request->merge(['password'=>bcrypt($request->password)]);
        $img = $request->file('image');
        $directionPath = public_path().'/uploads/image/restaurants/';
        $extension = $img->getClientOriginalExtension();
        $name = rand('22222','999999'). '.' . $extension;
        $img->move($directionPath, $name);
        $restaurant=Restaurant::create($request->all());
        $restaurant->image ='uploads/image/restaurants/'.$name;
        $restaurant = Restaurant::first();
        $token = JWTAuth::fromUser($restaurant);
        $restaurant->save();

        return apiResponse(1,'successed',['token'=>$token,'restaurant'=>$restaurant]);
    }

    //login
    public function login(Request $request)
    {
        $validator =validator()->make($request->all(),[
          'email'=>'required',
          'password'=>'required'
        ]);

        if($validator->fails())
        {
          return apiResponse(0,$validator->errors());
        }
        Config::set('jwt.user', 'App\Models\Restaurant');
        Config::set('auth.providers.users.model', \App\Models\Restaurant::class);
        $credentials = $request->only('email', 'password');
        $token = null;
        try {
                 if (!$token = JWTAuth::attempt($credentials)) {
                     return apiResponse(0,'بيانات عير صحيحة');
                 }
            }
        catch (JWTException $e)  //error in server
           {
                 return apiResponse(0,'حدث خطا في السيرفر');
           }
       return apiResponse(1,'تم التسجيل',[
         'token'=>$token,
         'restaurant'=>$request->email
       ]);
    }

    //reset-password
    public function resetPassword(Request $request)
    {
        $validator =validator()->make($request->all(),[
          'email'=>'required',
        ]);

        if($validator->fails())
        {
            return apiResponse(0,'من فضلك ادخل البريدالاكتروني',$validator->errors());
        }

        $restaurant = Restaurant::where('email', $request->email)->first();
        if($restaurant)
        {
          $code = rand(1111,9999);
          $update = $restaurant->update(['pin_code' => $code]);
          if($update)
          {
            Mail::to($restaurant->email)
                ->bcc("eman123456eman123@gmail.com")
                ->send(new ResetPassword($code));

            return apiResponse(1,'برجاء فحص بريدك' ,
            [
              'pin_code_for_test' =>$code,
            ]);

          }
          else {
            return apiResponse(0,'حدث خطا','حاول مرة اخري');
          }
        }
        else {
          return apiResponse(0,'لا يوجد الحساب');
        }

    }

  //new-password
   public function newPassword (Request $request)
   {

       $validator =validator()->make($request->all(),[
         'pin_code' =>'required',
         'email' => 'required',
         'password'=> 'required|confirmed'
       ]);

       if($validator->fails())
       {
         return apiResponse(0,$validator->errors()->first(),$validator ->errors());
       }

       $restaurant = Restaurant::where('pin_code' ,$request->pin_code)->where('pin_code' ,'!=',0)
       ->where('email',$request->email)->first();
       if ($restaurant)
       {
           $restaurant->password = bcrypt($request->password);
           $restaurant->pin_code = null ;

           if ($restaurant->save())
           {
              return apiResponse(1,'تم تغيير كلمة المرور بنجاح');
           }
           else {
             return apiResponse(0,'حدث خطا','حاول مرة اخري');
           }
        }
        else {
          return apiResponse(0,'هذا الكود غير صالح');
       }

   }

   //profile
    public function profile(Request $request)
    {
        $restaurant =$request->user();
        $restaurant->update($request->except('password'));

        if($request->has('password'))
        {
          $restaurant->password =bcrypt($request->password);
          $restaurant->save();
        }
        return apiResponse(1,'success',$restaurant);
    }

    // registerToken
    public function registerToken(Request $request)
    {
          $validator =  validator()->make($request->all(),[
            'token' => 'required' ,
            'type' => 'required|in:android,ios'
          ]);

          if($validator->fails())
          {
              $data = $validator->errors();
              return apiResponse(0,$validator->errors()->first(),$data);
          }

          Token::where('token',$request->token)->delete();
          $request->user()->tokens()->create($request->all());

          return apiResponse(1,'تم النسجيل بنجاح');
    }

    //removeToken
    public function removeToken(Request $request)
    {
          $validator = validator()->make($request->all(),[
            'token' => 'required',
          ]);

          if($validator->fails())
          {
            $data = $validator->errors();
            return apiResponse(0,$validator->errors()->first(),$data);
          }

          Token::where('token',$request->token)->delete();
          return apiResponse(1,'تم الحذف بنجاح');
    }

}
