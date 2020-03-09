<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\District;


class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $records = District::with('city')->paginate();
      return view('admin.districts.index' , compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('admin.districts.create' );

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $rule =[
      'name' =>'required',
      'city_id' =>'required',

      ];

      $messages =[
        'name.required' =>'الاسم مطلوب',
        'city_id.required' =>'اسم المدينة مطلوب',

      ];

      $this->validate($request ,$rule ,$messages);

      $record = District::create($request->all());
      // flash('success')->success();

      return redirect(route('district.index'));
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
      $model = District::findOrFail($id);
      return view('admin.districts.edit',compact('model'));
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
      $record = District::findOrFail($id);
      $record->update($request->all());
      // flash('Edited')->success();
      return redirect(route('district.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $record = District::findOrFail($id);
      $record->delete();
    // flash('Deleted')->error();
      return back();
    }
}
