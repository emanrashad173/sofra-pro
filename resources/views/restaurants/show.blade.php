@extends('layouts.admin-app')
@section('content')

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>المطاعم</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="{{url('/admin/')}}">الرئيسية</a></li>
            <li class="breadcrumb-item active">المطاعم</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>


  <!-- Main content -->
  <section class="content">
    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">المطاعم</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fa fa-times"></i></button>
        </div>
      </div>
      <div class="card-body">
        @if($record)
         <div class="table-responsive">
           <table class="table table-bordered">
                <tr>
                  <td >الاسم</td>
                  <td >{{$record->name}}</td>
                </tr>
                <tr>
                  <td>البريد الاليكتروني</td>
                  <td>{{$record->email}}</td>
                </tr>
                <tr>
                  <td>الهاتف</td>
                  <td>{{$record->phone}}</td>
                </tr>

                <tr>
                  <td>الحد الادني للطلب</td>
                  <td>{{$record->minimum_order}}</td>
                </tr>
                <tr>
                  <td>رسوم التوصيل</td>
                  <td>{{$record->delivery_cost}}</td>
                </tr>
                <tr>
                  <td>رقم الواتس</td>
                  <td>{{$record->whats_num}}</td>
                </tr>
                <tr>
                  <td>رقم التواصل</td>
                  <td>{{$record->phone_contact}}</td>
                </tr>
                <tr>
                  <td>الصورة</td>
                  <td><img src="{{asset($record->image)}}" style="height:100px;width:100px;"></td>
                </tr>
                <tr>
                  <td>التنشيط</td>
                  <td>{{$record->activation}}</td>
                </tr>
                <tr>
                  <td>المنطقة</td>
                  <td>{{$record->district->name}}</td>
                </tr>
                <tr>
                  <td>نسبة </td>
                  <td>{{$record->rate}}</td>
                </tr>

                <tr>
                  <td>التسجيل يوم</td>
                  <td>{{$record->created_at}}</td>
                </tr>
           </table>
         </div>
          @else
          <div class="alert alert.danger" role="alert">
             No Data
          </div>
        @endif
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </section>
  <!-- /.content -->


@endsection
