@extends('front.master')
@section('content')
    <section class="add-new-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 offset-sm-3">
                    <h1 class="text-center form-title">اضف منتج جديد</h1>
                    @inject('model' ,'App\Models\Offer')

                    {!! Form::model($model,[
                      'action' =>'Front\Restaurant\MainController@offerCreate',
                      'method' => 'post',
                      'files' => 'true'
                      ])!!}
                        <div class="img-input">
                            <div class="img">
                                <img src="{{asset('front/images/default-image.jpg')}}" alt="">
                                {!! Form::file('image',null, [
                                  'class' =>'bg-transparent',
                                   'id' => 'offer_image'
                                ])!!}
                                  @error('image')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                  @enderror
                            </div>
                            <p>صورة العرض</p>
                        </div>
                        <div class="input-group">
                          {!! Form::text('name' ,null, [
                            'id'=> 'product-name' ,
                            'placeholder' => 'اسم العرض'
                          ])!!}
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            {!! Form::textarea('description' ,null, [
                              'id'=> 'product-short-description' ,
                              'rows' => 4,
                              'placeholder' => 'وصف مختصر'
                            ])!!}
                              @error('description')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                              {!! Form::text('price' ,null, [
                                'id'=> 'product-price' ,
                                'placeholder' => 'سعر  العرض'
                              ])!!}
                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="input-group d-flex date">
                            <div>
                              <label >من </label>
                              {!! Form::date('from_date' ,null, [
                                'class' => 'from' ,
                              ])!!}
                                @error('from_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                             </div>
                             <div>
                               <label >الي </label>
                               {!! Form::date('to_date' ,null, [
                                 'class' => 'to' ,
                               ])!!}
                                 @error('to_date')
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                                 @enderror
                             </div>
                             </div>
                             <button type="submit" class="add-new-link btn">اضافة</button>
                    {!! Form::close()!!}
                </div>
            </div>
        </div>
    </section>


@endsection
