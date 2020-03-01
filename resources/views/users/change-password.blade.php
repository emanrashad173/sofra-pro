@extends('layouts.admin-app')
@section('content')
@inject('model','App\User')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>الادمن</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-left">
          <li class="breadcrumb-item"><a href="{{url('/admin/')}}">الرئيسية</a></li>
          <li class="breadcrumb-item active">تغيير كلمة المرور</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<section class="content">


  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">تغيير كلمة المرور</h3>

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
        'action' => ['UserController@updatePassword',$model->id],
        'method' => 'post'
        ])!!}
      <div class="form-group">
        <label for="old_password">كلمة المرور القديمة</label>
        {!! Form::password('old_password', [
        'class' =>'form-control'
        ])!!}
      </div>
      <div class="form-group">
        <label for="new_password">كلمة المرور الجديدة</label>
        {!! Form::password('password', [
        'class' =>'form-control'
        ])!!}
      </div>
      <div class="form-group">
        <label for="password_confirmation">تاكيد كلمة المرور الجديدة</label>
        {!! Form::password('password_confirmation' , [
        'class' =>'form-control'
        ])!!}
      </div>

      <div class="form-group">
        <button class="btn btn-primary" type="submit">تعديل</button>
      </div>
          {!! Form::close() !!}
    </div>

   </div>
  <!-- /.card -->

  </section>
  <!-- /.content -->


  @endsection
