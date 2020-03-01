@extends('front.master')
@section('content')
    <!-- start talabaty section -->
    <section class="orders">
        <div class="order-state py-5 d-flex">
            <div class="container">
               <div class="row">
                   <div class="col-md-6">
                        <h5 class="text-left"><a href="{{url('client/my-orders')}}">طلبات حالية</a></h5>
                   </div>
                   <div class="col-md-6">
                        <h5 class="text-right"><a href="{{url('client/my-previous-orders')}}">طلبات سابقة</a></h5>
                   </div>
               </div>
            </div>
        </div><!--End order-state-->
        <div class="order-details">
            <div class="container">
              @foreach($orders as $order)
                <div class="order-info my-5">
                    <div class="row text-center">
                        <div class="col-md-3 py-3 px-4">
                            <img src="{{asset('front/images/burger.jpg')}}" class="img-fluid" alt="">
                        </div>
                        <div class="col-md-8 py-3 text-left">
                            <h4 class="py-2">بيف برجر 250 جرام</h4>
                                <p class="py-1">رقم الطلب <span>{{$order->id}}</span></p>
                                <p class="py-1">المجموع :  <span>{{$order->cost}}</span> ريال</p>
                                 <p class="py-1"> التوصيل <span>{{$order->restaurant->delivery_cost}}</span></p>
                                <p class="py-1">الإجمالى :  <span>{{$order->total}}</span> ريال</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
