@extends('front.master')
@section('content')
    <!-- Start Header Section -->
    <header class="text-center">
        <div class="container">
            <div class="header-content">
                <h1>سفرة</h1>
                <p>بتشتري...بتبيع؟ كله عند ام ربيع</p>

                @guest
                <a class="register main-btn" href="{{url('client/login-client')}}">
                    <span>اطلب طعام</span>
                    <i class="fa fa-user"></i>
                </a>
                <a class="register main-btn" href="{{url('restaurant/login-restaurant')}}">
                    <span>بيع طعام</span>
                    <i class="fa fa-home"></i>
                </a>
                @endauth

            </div>
        </div>
    </header>
    <!-- End Header Section -->

    <!-- Start Favs Resturants Section -->
    <section class="favs text-center bg-gry">
        <div class="container">
          <h2>ابحث عن مطعمك المفضل</h2>

          {!! Form::open(['method'=>'GET','action'=>'Front\MainController@home','role'=>'search'])  !!}

            <div class="row">
                <div class="col-md-6">
                    <div class="select-box">
                        <i class="fa fa-arrow-down"></i>
                        {!! Form::select('city_id',App\Models\City::pluck('name','id')->toArray(),request('city_id'),[
                         'class' => 'form-control input-lg',
                         'placeholder' => 'اختر المدينة'
                        ])!!}

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="select-box">
                        <button type="submit" style="border:none; background-color:transparent;" ><i class="fa fa-search" style="top:45px;"></i></button>
                        {!! Form::text('search_by_name',request('search_by_name'),[
                            'placeholder' => 'ابحث بالاسم',
                            'class' => 'form-control input-lg'
                        ]) !!}
                    </div>
                </div>
            </div>
            {!! Form::close()!!}

         @foreach($restaurants->chunk(2) as $chunk)
            <div class="row">
             @foreach($chunk as $restaurant)
                <div class="col-md-6">
                    <div class="box text-center">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="{{asset('front/images/res-img.png')}}" alt="Favs">
                            </div>
                            <div class="col-md-4">
                                <a href="{{url('/restaurant-page/' .$restaurant->id)}}"><h3>{{$restaurant->name}}</h3> </a>
                              @include('front.partials.rate' , compact('restaurant'))
                                <p>الحد الادني للطلب <span>{{$restaurant->minimum_order}}</span> ريال</p>
                                <p>رسوم التوصيل : <span>{{$restaurant->delivery_cost}}</span> ريال</p>
                            </div>
                            <div class="col-md-4">
                                <span class="status">{{$restaurant->activation}}</span>
                            </div>
                        </div>
                    </div>
                </div>
              @endforeach
            </div>
          @endforeach
        </div>
    </section>
    <!-- End Favs Resturants Section -->

    <!-- Start Featues Section -->
    <section class="feats text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="offers">
                        <img src="{{asset('front/images/Group 1036.png')}}" alt="Offers">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <p>لوريم ايبسوم دولار سيت أميت ,كونسيكتيتور أدايبا يسكينج أليايت,سيت دو أيوسمود تيمبور
                            أنكايديديونتيوت لابوري ات دولار ماجنا أليكيوا . يوت انيم أد مينيم فينايم,كيواس نوستريد
                            أكسير سيتاشن يللأمكو لابورأس نيسي يت أليكيوب أكس أيا كوممودو كونسيكيوات .</p>
                        <a class="main-btn" href="{{url('/all-offers')}}">
                            شاهد العروض
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Featues Section -->

    <!-- Start Download Section -->
    <section class="download">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{asset('front/images/app mockup.png')}}" alt="Offers">
                </div>
                <div class="col-md-6">
                    <div class="card text-center">
                        <h2>قم بتحميل التطبيق الخاص بنا الان</h2>
                        <a class="main-btn" href="{{$settings->app_link}}">
                            <span>حمل الأن</span>
                            <i class="fa fa-arrow-down"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Download Section -->
@endsection
