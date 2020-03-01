@extends('front.master')
@section('content')
    <!-- start talabaty section -->
    <div class="container">
    <section class=" register-page py-5 my-5">
        <div class="reg1 mx-auto my-5">
            <div><img src="{{asset('front/images/use-img.png')}}" alt="user"></div>
              @inject('model' ,'App\Models\Client')

              {!! Form::model($model,[
                'action' =>'Front\Client\AuthController@registerSave',
                'method' => 'post',
                'class'=> 'p-5 my-3 text-center'
                ])!!}
                      {!! Form::text('name' ,null, [
                        'class' =>'form-control my-4',
                        'placeholder' => 'الاسم'
                      ])!!}
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                      {!! Form::text('email' ,null, [
                        'class' =>'form-control my-4',
                        'placeholder' => ' البريد الاليكتروني'
                      ])!!}
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                      {!! Form::text('phone' ,null, [
                        'class' =>'form-control my-4',
                        'placeholder'=> 'الجوال'
                      ])!!}
                        @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      @inject('city','App\Models\City')
                      {!!  Form::select('city_id' ,$city->pluck('name','id')->toArray(),null,[
                         'class' => 'form-control my-4',
                         'id' => 'city',
                         'placeholder' => 'اختر المدينة'
                      ]) !!}
                        @error('city_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                      {!!  Form::select('district_id' ,[],null,[
                         'class' => 'form-control my-4',
                         'id' => 'district',
                         'placeholder' => 'اختار الحي'
                      ]) !!}
                        @error('district_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                      {!! Form::password('password', [
                        'class' =>'form-control my-4',
                        'placeholder'=> 'كلمة المرور'
                      ])!!}
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                      {!! Form::password('password_confirmation' , [
                        'class' =>'form-control my-4',
                        'placeholder'=> '  تاكيد كلمة المرور '
                      ])!!}
                        @error('password_confirmation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                <div class="form-row">
                    <div class="col new-user">
                       <p>  بإنشاء حسابك أن توافق على <a href=""> شروط الاستخدام </a> الخاصة بسفرة</p>
                    </div>
                </div>
                <button type="submit" class="btn w-75 mt-4 text-white">دخول</button>
              {!! Form::close() !!}
        </div>
    </section>
    </div>
    @push('scripts')
      <script>
      //event for change
      $("#city").change(function(e){
        e.preventDefault();

      //get gov
      var city_id = $("#city").val();
      if(city_id)
      {

        //send ajax
         $.ajax({
           url : '{{url('api/v1/districts?city_id=')}}'+city_id,
           type : 'get',
           success: function(data){
             if(data.status==1)
             {
               $('#district').empty();
               $("#district").append('<option value=""> اختر حي</option>')
               $.each(data.data,function(index,district){
                 $("#district").append('<option value="'+district.id+'">'+district.name+'</option>')
               });
               // console.log(data);
             }

           },
           error: function(jqXhr, textStatus, errorMessage){
             alert(errorMessage);
           }
         });
      }
      else{
        $('#district').empty();
        $("#district").append('<option value=""> اختر حي</option>')
      }
      });
      </script>
      @endpush
@endsection
