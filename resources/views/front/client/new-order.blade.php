@extends('front.master')
@section('content')
    <!-- Start Contact Section-->
    <section class="contact-us">
        <div class="container">
              {!! Form::model($model,[
                'action' =>['Front\Client\MainController@createOrder',$model->id],
                'method' => 'put',
                'class' => 'contact-info'
                ])!!}
                <h1 class="text-center form-title">تفاصيل الطلب</h1>
                <div class="input-group">

                      {!! Form::textarea('notes' ,null, [
                      'rows' => '10',
                       'id' => 'msg' ,
                      'placeholder'=> 'اضافة ملاحظات'
                      ])!!}
                      @error('message')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                </div></br>
                <h5>عنوان التوصيل : <span>{{auth('web-client')->user()->address}}</span></h5>
              </br>
               <h5> الدفع</h5>
                <div class="input-group buttons">
                    <label class="d-flex flex-row"><span>نقدا عند الاستلام</span> <input checked class="w-auto ml-2" type="radio" value= "1" name="payment_method_id"></label>
                    <label class="d-flex flex-row"><span>الدفع اونلاين</span> <input class="w-auto ml-2" type="radio" value= "2" name="payment_method_id"></label>
                </div>
              </br>
                <div>
                    <h5>المجموع : {{$model->cost}}</h5>
                    </br>
                    <h5>رسوم التوصيل : {{$model->delivery_cost}}</h5>
                    </br>
                    <h5>الاجمالي: {{$model->total}}</h5>
                </div>
                  <button type="submit" class="add-new-link btn">اضافة</button>
            {!! Form::close() !!}
        </div>
    </section>
@endsection
