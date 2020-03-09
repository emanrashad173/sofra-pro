@extends('layouts.admin-app')
@section('content')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>المناطق</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="{{url('/admin/')}}">الرئيسية</a></li>
            <li class="breadcrumb-item active">المناطق</li>
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
        <h3 class="card-title">قائمة المناطق</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fa fa-times"></i></button>
        </div>
      </div>
      <div class="card-body">
        <a href="{{url(route('district.create'))}}" class="btn btn-primary"><i class="fa fa-plus"></i>اضافة منطقة</a>

          @if(count($records))
           <div class="table-responsive">
             <table class="table table-bordered">
               <thead>
                 <tr>
                   <th>الرقم</th>
                   <th>الاسم</th>
                   <th>المدينة</th>
                   <th class="text-center">تعديل</th>
                   <th class="text-center">حذف</th>
                 </tr>
               </thead>
               <tbody>

                 @foreach($records as $record)
                  <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$record->name}}</td>
                    <td>{{$record->city->name}}</td>
                    <td class="text-center">
                      <a href="{{url(route('district.edit',$record->id))}}" class="btn btn-success btn-xs"><i class="fa fa-edit fa-lg"></i></a>
                    </td>
                    <td class="text-center">
                      {!! Form::open([
                        'action' =>['Admin\DistrictController@destroy' ,$record->id],
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
