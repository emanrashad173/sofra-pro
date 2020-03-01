@extends('front.master')
@section('content')
    <!-- Start Contact Section-->
    <section class="contact-us">
        <div class="container">
              {!! Form::model($model,[
                'action' =>['Front\Client\AuthController@profileSet',$model->id],
                'method' => 'put',
                'class'=> 'contact-info'
              ])!!}
              <div class="text-center my-3"><i class="fas fa-user-circle"></i></div>
              <div class="input-group">
                    {!! Form::text('name',auth('web-client')->user()->name, [
                      'id' => 'offer-name',
                      'placeholder' => 'الاسم'
                    ])!!}

                    {!! Form::text('email' ,auth('web-client')->user()->email, [
                      'id' => 'email' ,
                      'placeholder' => ' البريد الاليكتروني'
                    ])!!}

                    {!! Form::text('phone' ,auth('web-client')->user()->phone, [
                      'id' => 'phone' ,
                      'placeholder' => 'الجوال'
                    ])!!}

                    @inject('city','App\Models\City')
                    {!!  Form::select('city_id' ,$city->pluck('name','id')->toArray(),null,[
                       'id' => 'city',
                       'placeholder' => 'اختر المدينة'
                    ]) !!}

                    {!!  Form::select('district_id' ,[],null,[
                       'id' => 'district',
                       'placeholder' => 'اختار الحي'
                    ]) !!}

                    {!! Form::textarea('address' ,auth('web-client')->user()->address, [
                    'id' => 'msg' ,
                    'rows' => '10' ,
                    'placeholder'=> 'العنوان بالتفصيل'

                    ])!!}

                </div>
              <button type="submit" class="add-new-link" style="border:none;" >حفظ التعديل</button>
                {!! Form::close() !!}

        </div>
    </section>

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
