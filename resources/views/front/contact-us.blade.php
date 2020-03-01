@extends('front.master')
@section('content')
    <!-- Start Contact Section-->
    <section class="contact-us">
        <div class="container">
              @inject('model','App\Models\Contact')
              {!! Form::model($model,[
                'action' =>'Front\MainController@contactSave',
                'method' => 'post',
                'class' => 'contact-info'
                ])!!}
                <h1 class="text-center form-title">تواصل معنا</h1>
                <div class="input-group">
                  {!! Form::text('name',null, [
                      'placeholder'=> 'الاسم',
                      'id' => 'offer-name' ,
                      ])
                      !!}
                      @error('name')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror

                      {!! Form::text('email' ,null, [
                      'id' => 'email' ,
                      'placeholder'=> ' البريد الاليكترونى'
                      ])!!}
                      @error('email')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror

                      {!! Form::text('phone' ,null, [
                      'id' => 'phone' ,
                      'placeholder'=> 'الجوال'
                      ])!!}
                      @error('phone')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror

                      {!! Form::textarea('message' ,null, [
                      'rows' => '10',
                       'id' => 'msg' ,
                      'placeholder'=> 'ماهي رسالتك'
                      ])!!}
                      @error('message')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                </div>
                <div class="input-group buttons">

                    <label class="d-flex flex-row"><span>شكوى</span> <input checked class="w-auto ml-2" type="radio" value= "complaint" name="type"></label>
                    <label class="d-flex flex-row"><span>اقتراح</span> <input class="w-auto ml-2" type="radio" value= "suggestion" name="type"></label>
                    <label class="d-flex flex-row"><span>استعلام</span> <input class="w-auto ml-2" type="radio" value= "inquiry" name="type"></label>
                </div>
                  <button type="submit" class="add-new-link btn">اضافة</button>
            {!! Form::close() !!}
        </div>
    </section>

    <!-- Start Contact Section-->
@endsection
