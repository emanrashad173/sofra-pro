@extends('front.master')
@section('content')
    <!-- start talabaty section -->
    <div class="container">
    <section class=" register-page py-5 my-5">
        <div class="reg mx-auto my-5">
            <div><img src="{{asset('front/images/use-img.png')}}" alt="user"></div>
            @inject('model' ,'App\Models\Client')
            {!! Form::model($model,[
              'action' =>'Front\Client\AuthController@loginSubmit',
              'method' => 'post',
              'class'=> 'p-5 my-3 text-center'
            ])!!}

                {!! Form::text('email' ,null, [
                   'class' =>'form-control my-4',
                   'placeholder'=> 'البريد الاليكترونى'
                ])!!}
                @error('email')
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
                <button type="submit" class="btn w-75 my-4 text-white">دخول</button>
                <div class="form-row my-3">
                    <div class="col new-user">
                        <a href="{{url('client/register-client')}}">مستخدم جديد ؟</a>
                    </div>
                    <div class="col pass">
                        <a href="{{url('client/reset-password-client')}}">نسيت كلمة السر ؟</a>
                    </div>
                </div>
                <button type="submit" class="btn w-75 my-4 text-white">انشيء حساب الآن</button>
            {!! Form::close() !!}
        </div>
    </section>
    </div>
@endsection
