@extends('front.master')
@section('content')
    <!-- start talabaty section -->
    <div class="container">
    <section class=" register-page py-5 my-5">
        <div class="reg mx-auto my-5">
            <div><img src="{{asset('front/images/use-img.png')}}" alt="user"></div>
            @inject('model' ,'App\Models\Restaurant')
            {!! Form::model($model,[
              'action' =>'Front\Restaurant\AuthController@passwordReset',
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

                <button type="submit" class="btn w-75 my-4 text-white">دخول</button>
            {!! Form::close() !!}
        </div>
    </section>
    </div>
@endsection
