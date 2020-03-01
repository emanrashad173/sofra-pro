@extends('front.master')
@section('content')
    <!--==============First section=======-->
    <section id="header">
        <div class="container">
            <div class="header-desc">
                <img class="website-name" src="" alt="" style="margin: 0 auto;">
                <h1 class="res-name"></h1>
                <ul class="list-unstyled">
                    <li class="fa fa-star"></li>
                    <li class="fa fa-star"></li>
                    <li class="fa fa-star"></li>
                    <li class="fa fa-star"></li>
                    <li class="fa fa-star"></li>
                </ul>
            </div>
        </div>
    </section>
    <div class="add-to-cart-sec" style="margin-top:50px;">
      <div class="text-center">
        <button type="button" class="btn btn-primary" style="background-color:#ec3454;width:180px;height:50px; border-radius:30px;border:none;"><a href="{{url('comments/'.Request::route('restaurant') )}}" style="font-size:20px; color:white;" >التقييم و التعليقات</a>
      </div>
      <div class="cart-info" style="margin-right:10px;" >
          <i class="fas fa-info"></i>
          <a href=""><span>معلومات عن المتجر</span></a>
      </div>
    </div>


    <section class="food">
        <div class="container">
          @foreach($products->chunk(3) as $chunk)
            <div class="row">
              @foreach($chunk as $product)
                <div class="col-sm-4">
                    <div class="item-holder">
                        <img src="{{asset($product->image)}}" alt="item-image" width="100%">
                        <div class="item-data text-center">
                            <h3 class="item-title">{{$product->name}}</h3>
                            <p class="item-description">{{$product->description}} </p>
                        </div>
                        <div class="features">
                            <div>
                                    <img src="{{asset('front/images/piggy-bank.png')}}" alt="" width="30px;">
                                <span class="delevery-time">
                                    {{$product->preparation_time}} دقيقة تقريبا
                                </span>
                            </div>
                            <div>
                                    <img src="{{asset('front/images/piggy-bank.png')}}" alt="" width="30px;">
                                <span class="delevery-time">
                                    {{$product->price}} ريال
                                </span>
                            </div>
                            <a href="{{url('/product-show/' .$product->id)}}" class="d-block">اضغط للتفاصيل</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endforeach
        </div>
    </section>
@endsection
