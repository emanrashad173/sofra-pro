@extends('layouts.admin-app')
@inject('client','App\Models\Client')
@inject('restaurant','App\Models\Restaurant')
@inject('offer','App\Models\Offer')
@inject('order','App\Models\Order')
@section('content')

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
        <div class="text-center">
          <h1 >الرئيسية</h1>
        </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
      <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-users"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">العملاء</span>
                  <span class="info-box-number">{{$client->count()}}</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
        <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-bookmark"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">المطاعم</span>
                  <span class="info-box-number">{{$restaurant->count()}}</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
        <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fa fa-shopping-cart"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">الطلبات</span>
                  <span class="info-box-number">{{$order->count()}}</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>

        <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fa fa-gift"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">العروض</span>
                  <span class="info-box-number">{{$offer->count()}}</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->

    <!-- /.card -->

  </section>
  <!-- /.content -->

@endsection
