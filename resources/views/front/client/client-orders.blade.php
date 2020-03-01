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
                        <div class="col-md-5 pt-md-5 text-left">
                            <h4 class="py-2">بيف برجر</h4>
                                <p class="py-2">رقم الطلب <span>{{$order->id}}</span></p>
                                <p class="py-2">المجموع :  <span>{{$order->total}}</span> ريال</p>
                        </div>
                        <div class="col-md-4 pt-md-5 px-5">
                            <a href=" {{url('client/deliver-order/'.$order->id)}}"><button class="btn btn-success px-5 d-block my-4">استلام</button></a>
                            <a href=" {{url('client/decline-order/'.$order->id)}}"><button class="btn btn-danger px-5 d-block my-4">رفض</button></a>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </section>
@endsection
