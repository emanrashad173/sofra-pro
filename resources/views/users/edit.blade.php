@extends('layouts.admin-app')
@section('content')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>مستخدم</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="{{url('/admin/')}}">الرئيسية</a></li>
            <li class="breadcrumb-item active">مستخدم</li>
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
        <h3 class="card-title">تعديل مستخدم</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fa fa-times"></i></button>
        </div>
      </div>
      <div class="card-body">
       @include('partials.validation_errors')

       {!! Form::model($model,[
         'action' => ['UserController@update',$model->id],
         'method' => 'put'
         ])!!}
       @include('users.form')

      {!! Form::close() !!}

      <!-- /.card-body -->
      </div>

    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->


@endsection
