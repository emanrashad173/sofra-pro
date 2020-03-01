<?php

namespace App\Http\Controllers\Client\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;
use App\Models\Client;
use App\Models\Token;


class AuthController extends Controller
{
    //Register
    public function register(Request $request)
    {
        $validator = validator()->make($request->all(),[
          'name'=>'required',
          'phone'=>'required|digits:11',
          'email'=>'required|unique:clients',
          'password'=>'required|confirmed',
          'district_id'=>'required',
        ]);

        if($validator->fails())
        {
            return apiResponse(0,$validator->errors()->first(),$validator->errors());
        }

        $request->merge(['password'=>bcrypt($request->password)]);
        $client=Client::create($request->all());
        $client->api_token = Str::random(60);
        $client->save();

        return apiResponse(1,'successed',['api_token'=>$client->api_token,'client'=>$client]);
    }

    //login
    public function login(Request $request)
    {
        $validator =validator()->make($request->all(),[
          'email'=>'required',
          'password'=>'required'
        ]);

        $client=Client::where('email',$request->email)->first();

        if($client)
        {
           if(Hash::check($request->password,$client->password)){
               return apiResponse(1,'تم التسجيل',[
                 'api_token'=>$client->api_token,
                 'client'=>$client
               ]);
           }
           else
           {
               return apiResponse(0,'بيانات عير صحيحة');
           }
        }
        else
        {
          return apiResponse(0,'بيانات عير صحيحة');
        }
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
