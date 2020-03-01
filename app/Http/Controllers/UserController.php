<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use app\Http\Controllers\Auth;
use App\User;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::paginate(20);
        return view('users.index' , compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(User $model)
    {
        return view('users.create',compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      // return $request->all();
      $this->validate($request,[
        'name'=>'required',
        'password' => 'required|confirmed',
        'email' => 'email',
        'roles_list' => 'required'
      ]);
       $request->merge(['password' => bcrypt($request->password)]);
       $user = User::create($request->except('roles_list'));
       $user->roles()->attach($request->input('roles_list'));
       flash('تم الحفظ')->success();
        return redirect(route('user.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = User::findOrFail($id);
        return view('users.edit',compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $this->validate($request,[
        'name'=>'required',
        'password' => 'required|confirmed',
        'email' => 'email',
        'roles_list' => 'required'
      ]);
      $user = User::findOrFail($id);
      $user->roles()->sync((array) $request->input('roles_list'));
      $request->merge(['password' => bcrypt($request->password)]);
      $update = $user->update($request->all());
      flash('تم التعديل')->success();
      return redirect(route('user.index' ,$id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $user = User::findOrFail($id);
      $user->delete();
      flash('تم الحذف')->error();
      return back();
    }

    public function changePassword()
    {
      return view('users.change-password');
    }


    public function updatePassword(Request $request)
    {
      $this->validate($request, [
       'old_password'     => 'required',
       'password'     => 'required|min:6',
       'password_confirmation' => 'required|same:password',
   ]);

   // $data = $request->all();
   // // dd($data);
   if (!Hash::check($request->get('old_password'), auth()->user()->password)) {
        return redirect()->back()->withErrors(['old_password' => 'Old password incorrect']);
    }
    // Update current password
    auth()->user()->password = bcrypt($request->get('password'));
    $request->user()->save();

    return view('admin-home');


    }
}
