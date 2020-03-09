@extends('layouts.admin-app')
@section('content')

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>الطلبات</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="{{url('/admin/')}}">الرئيسية</a></li>
            <li class="breadcrumb-item active">الطلبات</li>
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
        <h3 class="card-title">الطلب</h3>

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
                  <td >المطعم</td>
                  <td class="col sm-3">{{$record->restaurant->name}}</td>
                </tr>
                <tr>
                  <td>العميل</td>
                  <td>{{$record->client->name}}</td>
                </tr>
                <tr>
                  <td>الملاحظات</td>
                  <td>{{$record->notes}}</td>
                </tr>
                <tr>
                  <td>العنوان</td>
                  <td>{{$record->address}}</td>
                </tr>
                <tr>
                  <td>الحالة</td>
                  <td>{{$record->state}}</td>
                </tr>
                <tr>
                  <td>التكلفة</td>
                  <td>{{$record->cost}}</td>
                </tr>
                <tr>
                  <td>العمولة</td>
                  <td>{{$record->commission}}</td>
                </tr>
                <tr>
                  <td>التكلفةالكاملة</td>
                  <td>{{$record->total}}</td>
                </tr>
                <tr>
                  <td>طرق الدفع</td>
                  <td>{{$record->paymentMethod->title}}</td>
                </tr>
                <tr>
                  <td>التكلفة للمطعم </td>
                  <td>{{$record->net}}</td>
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
