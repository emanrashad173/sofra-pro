<?php

namespace App\Http\Controllers\Front\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;
use App\Models\Client;

class AuthController extends Controller
{
    //register
    public function register()
    {
      return view('front.client.register-client');
    }

    //registerSave
    public function registerSave(Request $request)
    {
      $validator = $this->validate($request,[
        'name'=>'required',
        'email'=>'required|unique:clients',
        'district_id'=>'required',
        'phone'=>'required',
        'password'=>'required|confirmed',
      ]);

      $request->merge(['password'=>bcrypt($request->password)]);
      $client=Client::create($request->all());
      $client->api_token = Str::random(60);
      auth('web-client')->login($client);
      $client->save();
      return redirect('/home');
     }

     //login
     public function login(Client $model)
     {
        return view('front.client.login-client',compact('model'));
     }

     //loginSave
     public function loginSubmit(Request $request)
     {
       $validator = $this->validate($request,[
          'email'=>'required',
          'password'=>'required'
       ]);

       $client=Client::where('email',$request->email)->first();
       if($client)
       {
         if(Hash::check($request->password,$client->password))
         {
           auth('web-client')->login($client);
           return redirect('/home');
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
      auth('web-client')->logout();
      return redirect('/home');
    }

     //resetPassword
     public function resetPassword(Client $model)
     {
      return view('front.client.reset-password-client',compact('model'));
     }

     //passwordReset
     public function passwordReset(Request $request)
     {
        $user = Client::where('email', $request->email)->first();

        if($user)
        {
          $code = rand(1111,9999);
          $update = $user->update(['pin_code' => $code]);
          if($update)
          {
            Mail::to($user->email)
                ->bcc("eman123456eman123@gmail.com")
                ->send(new ResetPassword($code));

            return redirect('/new-password-client');
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
    public function newPassword(Client $model)
    {
      return view('front.client.new-password-client',compact('model'));
    }

    //passwordChanged
    public function passwordChanged (Request $request)
    {
      $validator = $this->validate($request,[
        'pin_code' =>'required',
        'email' => 'required',
        'password'=> 'required|confirmed'
      ]);

      $user = Client::where('pin_code' ,$request->pin_code)->where('pin_code' ,'!=',0)
      ->where('email',$request->email)->first();
      if ($user)
      {
          $user->password = bcrypt($request->password);
          $user->pin_code = null ;
          $user->save();
          return redirect('/home');

       }
       else{
         return redirect()->back();
       }
    }

    //profile
    public function profile(Client $model)
    {
       return view('front.client.profile-client',compact('model'));
    }

    //profileSet
    public function profileSet(Request $request)
    {
        $user =auth('web-client')->user();
        $user->update($request->all());
        $user->save();
        return redirect('/home');
    }


}
