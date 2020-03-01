@extends('front.master')
@section('content')
    <!--==============First section=======-->
    <section id="header">
        <div class="container">
            <div class="header-desc">
                <img class="website-name" src="{{asset(auth('web-restaurant')->user()->image)}}" alt="" style="margin: 0 auto;">
                <h1 class="res-name">{{auth('web-restaurant')->user()->name}}</h1>
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


    <section class="food">
        <div class="container">
            <div class="row text-center">
                <div class="col-sm-12">
                    <h1><a >قائمة الطعام</a>/ <span>منتجاتى</span></h1>
                </div>
                <div class="col-sm-12">
                    <a href="{{url('restaurant/new-product')}}" class="btn minu-btn my-5 px-5">اضف منتج جديد</a>
                </div>
            </div>
            @foreach($products->chunk(3) as $chunk)
            <div class="row">
              @foreach($chunk as $product)
                <div class="col-sm-4">
                    <div class="item-holder">
                        <img src="{{asset($product->image)}}" alt="" width="100%">
                        <div class="item-data text-center">
                            <h3 class="item-title">{{$product->name}}</h3>
                            <p class="item-description">{{$product->description}}</p>
                        </div>
                        <div class="features">
                            <div>
                                    <img src="{{asset('front/images/piggy-bank.png')}}" alt="" width="30px;">
                                <span class="delevery-time">
                                    {{$product->price}} ريال
                                </span>
                            </div>
                            <a href="{{url('restaurant/edit-product/' .$product->id)}}"  style="width:100px;height:45px;margin-right:80px;padding-top:10px"class="d-block">تعديل</a>

                        </div>
                        <div class="closed">
                          {!! Form::open([
                            'url' => 'restaurant/product-delete/'.$product->id,
                            'method' => 'delete'
                          ])!!}
                            <button type="submit" style="border:none; background-color:transparent;"><i class="fas fa-times-circle"></i></button>
                          {!! Form::close()!!}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endforeach
        </div>
    </section>


@endsection
