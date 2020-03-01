<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;


class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $records = PaymentMethod::paginate();
      return view('payment_methods.index' , compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('payment_methods.create' );

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
      'title' =>'required',
      ];

      $messages =[
        'title.required' =>'الاسم مطلوب',
      ];

      $this->validate($request ,$rule ,$messages);

      $record = PaymentMethod::create($request->all());
      // flash('success')->success();

      return redirect(route('payment-method.index'));
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
      $model = PaymentMethod::findOrFail($id);
      return view('payment_methods.edit',compact('model'));
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
      $record = PaymentMethod::findOrFail($id);
      $record->update($request->all());
      // flash('Edited')->success();
      return redirect(route('payment-method.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $record = PaymentMethod::findOrFail($id);
      $record->delete();
    // flash('Deleted')->error();
      return back();
    }
}
