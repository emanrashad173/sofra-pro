<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;
use App\Models\Client;
use App\Models\Token;
use JWTAuth;
use JWTFactory;
use Response;
use Config;



class AuthController extends Controller
{

  public function __construct()
    {
        Auth::shouldUse('api-client');
    }

    //Register
    public function register(Request $request)
    {
        $validator = validator()->make($request->all(),[
          'name'=>'required',
          'phone'=>'required|digits:11',
          'email'=>'required|email|unique:clients',
          'password'=>'required|confirmed',
          'district_id'=>'required',
        ]);

        if($validator->fails())
        {
            return apiResponse(0,$validator->errors()->first(),$validator->errors());
        }

        $request->merge(['password'=>bcrypt($request->password)]);
        $client= Client::create($request->all());
        $client = Client::first();
        $token = JWTAuth::fromUser($client);

        return apiResponse(1,'successed',['token'=>$token,'client'=>$client]);
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
        Config::set('jwt.user', 'App\Models\Client');
		    Config::set('auth.providers.users.model', \App\Models\Client::class);
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
         'client'=>$request->email
       ]);
    }

    //Reset-password
    public function resetPassword(Request $request)
    {
        $validator =validator()->make($request->all(),[
          'email'=>'required',
        ]);

        if($validator->fails())
        {
            return apiResponse(0,'من فضلك ادخل البريدالاكتروني',$validator->errors());
        }

        $client = Client::where('email', $request->email)->first();

        if($client)
        {
          $code = rand(1111,9999);
          $update = $client->update(['pin_code' => $code]);

          if($update)
          {
            Mail::to($client->email)
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

       $client = Client::where('pin_code' ,$request->pin_code)->where('pin_code' ,'!=',0)
       ->where('email',$request->email)->first();

       if ($client)
       {
           $client->password = bcrypt($request->password);
           $client->pin_code = null ;

           if ($client->save())
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

   //Profile
    public function profile(Request $request)
    {
        $client =$request->user();
        $client->update($request->except('password'));
        if($request->has('password'))
        {
          $client->password =bcrypt($request->password);
          $client->save();
        }
        return apiResponse(1,'success',$client);
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

   // RemoveToken

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
