@extends('layouts.admin-app')
@section('content')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>المستخدمين</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="{{url('/admin/')}}">الرئيسية</a></li>
            <li class="breadcrumb-item active">المستخدمين</li>
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
        <h3 class="card-title">قائمة المستخدمين</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fa fa-times"></i></button>
        </div>
      </div>
      <div class="card-body">
        <a href="{{url(route('user.create'))}}" class="btn btn-primary"><i class="fa fa-user-plus"></i> مستخدم جديد </a>


        @include('flash::message')


        @if(count($users))
         <div class="table-responsive">
           <table class="table table-bordered">
             <thead>
               <tr>
                 <th>الرقم</th>
                 <th>الاسم</th>
                 <th>البريد الاليكتروني</th>
                 <th>الرتبة</th>
                 <th class="text-center">تعديل</th>
                 <th class="text-center">حذف</th>
               </tr>
             </thead>
             <tbody>
               @foreach($users as $user)
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{$user->name}}</td>
                  <td>{{$user->email}}</td>
                  <td>
                  @foreach($user->roles as $role)
                   <span class="badge badge-warning">{{$role->display_name}}</span>
                  @endforeach
                </td>
                  <td class="text-center">
                    <a href="{{url(route('user.edit',$user->id))}}" class="btn btn-success btn-xs"><i class="fa fa-edit"></i></a>
                  </td>
                  <td class="text-center">
                    {!! Form::open([
                      'action' =>['UserController@destroy' ,$user->id],
                      'method' => 'delete'
                      ])!!}
                      <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                      {!! Form::close()!!}
                  </td>

                </tr>
               @endforeach
             </tbody>

           </table>
         </div>
          @else
          <div class="alert alert.danger" role="alert">
لاتوجد بيانات
          </div>
        @endif
      </div>
      <!-- /.card-body -->

    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->


@endsection
