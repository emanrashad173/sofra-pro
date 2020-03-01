@extends('front.master')
@section('content')
    <!-- start talabaty section -->
    <section class="orders">
        <div class="order-state py-5 d-flex">
            <div class="container">
               <div class="row">
                 <div class="col-md-4">
                      <h5 class="text-left"><a href="{{url('restaurant/new-orders')}}">طلبات جديدة</a></h5>
                 </div>
                 <div class="col-md-4">
                      <h5 class="text-center"><a href="{{url('restaurant/current-orders')}}">طلبات حالية</a></h5>
                 </div>
                 <div class="col-md-4">
                      <h5 class="text-right"><a href="{{url('restaurant/previous-orders')}}">طلبات سابقة</a></h5>
                 </div>
               </div>
            </div>
        </div><!--End order-state-->
        <div class="order-details">
            <div class="container">
              @foreach($orders as $order)
                <div class="order-current my-5">
                    <div class="row text-center">
                        <div class="col-md-3 py-3 px-4">
                            <img src="images/user-photo.png" class="img-fluid" alt="">
                        </div>
                        <div class="col-md-8 pt-3 text-left">
                            <p class="py-1"> العميل : <span>{{$order->client->name}} </span></p>
                                <p class="py-1 mncolor">رقم الطلب <span>{{$order->id}}</span></p>
                                <p class="py-1 mncolor">المجموع :  <span>{{$order->total}}</span> ريال</p>
                                <p class="py-1 mncolor">العنوان :  <span>{{$order->address}}</span></p>
                        </div>
                        <div class="col mb-4">
                          @if($order->state == "delivered" || "confirmed")
                            <button class="btn btn-success mx-3 px-5">الطلب مكتمل</button>
                          @else($order->state == "declined" || "rejected")
                            <button class="btn btn-success mx-3 px-5">الطلب مرفوض</button>
                          @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
