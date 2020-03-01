@extends('layouts.admin-app')
@section('content')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>العروض</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="{{url('/admin/')}}">الرئيسية</a></li>
            <li class="breadcrumb-item active">العروض</li>
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
        <h3 class="card-title">قائمة العروض</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fa fa-times"></i></button>
        </div>
      </div>
      <div class="card-body">
        {!! Form::open(['method'=>'GET','action'=>'OfferController@index','class'=>'navbar-form navbar-left','role'=>'search'])  !!}

        <div class="row">

          <div class="col-sm-3">
                {!! Form::select('restaurant_id',App\Models\Restaurant::pluck('name' ,'id')->toArray(),request('restaurant_id'),[
                  'class' => 'form-control',
                  'placeholder' => 'اختر المطعم'
                  ])!!}
              </div>

          <div class="col-sm-3">
            <button type="submit" class="btn btn-primary "><i class="fa fa-search"></i> بحث</button>
          </div>

        </div>
        {!! Form::close()!!}
        </br>

          @if(count($records))
           <div class="table-responsive">
             <table class="table table-bordered">
               <thead>
                 <tr>
                   <th>الرقم</th>
                   <th>المطعم</th>
                   <th>الصورة</th>
                   <th>الوصف</th>
                   <th>من تاريخ</th>
                   <th>الي تاريخ</th>
                   <th class="text-center">حذف</th>
                 </tr>
               </thead>
               <tbody>

                 @foreach($records as $record)
                  <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$record->restaurant->name}}</td>
                    <td><img src="{{asset($record->image)}}" style="height:100px;width:100px;"></td>
                    <td>{{$record->description}}</td>
                    <td>{{$record->from_date}}</td>
                    <td>{{$record->to_date}}</td>
                    <td class="text-center">
                      {!! Form::open([
                        'action' =>['OfferController@destroy' ,$record->id],
                        'method' => 'delete'
                      ])!!}
                        <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash fa-lg"></i></button>
                        {!! Form::close()!!}
                    </td>
                  </tr>
                 @endforeach
               </tbody>
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
