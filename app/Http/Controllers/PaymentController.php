<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;


class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $records = Payment::where(function($query) use($request){
          if ($request->input('restaurant_id')) {
          $query->where('restaurant_id',$request->restaurant_id);
          }
        })->paginate(20);
      return view('payments.index' , compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('payments.create' );

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
      'received_money' =>'required',
      'date' =>'required',
      'restaurant_id' =>'required',
      ];

      $messages =[
        'received_money.required' =>'النقود المدفوعة',
        'date.required' =>'الوقت مطلوب',
        'restaurant_id.required' =>'المطعم مطلوب',

      ];

      $this->validate($request ,$rule ,$messages);

      $record = Payment::create($request->all());
      // flash('success')->success();

      return redirect(route('payment.index'));
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
      $model = Payment::findOrFail($id);
      return view('payments.edit',compact('model'));
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
      $record = Payment::findOrFail($id);
      $record->update($request->all());
      // flash('Edited')->success();
      return redirect(route('payment.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $record = Payment::findOrFail($id);
      $record->delete();
    // flash('Deleted')->error();
      return back();
    }
}
