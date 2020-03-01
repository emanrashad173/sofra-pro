<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>سفرة ادمن</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('adminlte/css/adminlte.min.css')}}">
  <!--select2-->
  <link rel="stylesheet" href="{{asset('select2/dist/css/select2.min.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- bootstrap rtl -->
  <link rel="stylesheet" href="{{asset('adminlte/css/bootstrap-rtl.min.css')}}">
  <!-- template rtl version -->
  <link rel="stylesheet" href="{{asset('adminlte/css/custom-style.css')}}">

  <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">

<style>
*{
  font-family: 'Cairo',sans-serif;
}
</style>
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>
    </ul>


    <!-- Right navbar links -->
    <ul class="navbar-nav mr-auto">
            <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                      <img src="{{asset('adminlte/img/admin-pic.png')}}" style="height:40px;width:40px;"class="img-circle elevation-2" >
                      <span class="hidden-xs">{{auth()->user()->name}} </span>
                    </a>
                    <ul class="dropdown-menu">
                      <!-- Menu Footer-->
                      <li class="user-footer">

                        <div class="pull-right">
                          {!! Form::open(['url'=>route('logout')]) !!}
                             <button type="submit" class="btn btn-default btn-flat">خروج</button>
                          {!! Form::close() !!}
                        </div>
                      </li>
                    </ul>
                </li>
            </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../index3.html" class="brand-link">
      <img src="{{asset('adminlte/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">سفرة</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <div>
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="{{asset('adminlte/img/admin-pic.png')}}" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">{{auth()->user()->name}}</a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-users"></i>
                <p>
                  المستخدمين
                  <i class="right fa fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{url(route('user.index'))}}" class="nav-link">
                    <i class="fa fa-user"></i>
                    <p>المستخدمين</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{url(route('role.index'))}}" class="nav-link">
                    <i class="fa fa-list"></i>
                    <p>الرتب</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="{{url(route('city.index'))}}" class="nav-link">
                <i class="nav-icon fa fa-map-marker"></i>
                <p>المدن</p>
              </a>
           </li>
           <li class="nav-item">
             <a href="{{url(route('district.index'))}}" class="nav-link">
               <i class="nav-icon fa fa-flag"></i>
               <p>المناطق</p>
             </a>
          </li>
          <li class="nav-item">
            <a href="{{url(route('restaurant.index'))}}" class="nav-link">
              <i class="nav-icon fa fa-bookmark"></i>
              <p>المطاعم</p>
            </a>
         </li>
         <li class="nav-item">
           <a href="{{url(route('client.index'))}}" class="nav-link">
             <i class="nav-icon fa fa-users"></i>
             <p>العملاء</p>
           </a>
        </li>
          <li class="nav-item">
            <a href="{{url(route('setting.index'))}}" class="nav-link">
              <i class="nav-icon fa fa-cogs"></i>
              <p>الاعدادات</p>
            </a>
         </li>
         <li class="nav-item">
           <a href="{{url(route('category.index'))}}" class="nav-link">
             <i class="nav-icon fa fa-list"></i>
             <p>المصنفات</p>
           </a>
        </li>
        <li class="nav-item">
          <a href="{{url(route('contact.index'))}}" class="nav-link">
            <i class="nav-icon fa fa-phone"></i>
            <p>المتصلين</p>
          </a>
       </li>
       <li class="nav-item">
         <a href="{{url(route('payment.index'))}}" class="nav-link">
           <i class="nav-icon fa fa-money"></i>
           <p>المدفوعات</p>
         </a>
      </li>
      <li class="nav-item">
        <a href="{{url(route('payment-method.index'))}}" class="nav-link">
          <i class="nav-icon fa fa-money"></i>
          <p>طرق الدفع</p>
        </a>
     </li>
      <li class="nav-item">
        <a href="{{url(route('offer.index'))}}" class="nav-link">
          <i class="nav-icon fa fa-gift"></i>
          <p>العروض</p>
        </a>
     </li>
     <li class="nav-item">
       <a href="{{url(route('order.index'))}}" class="nav-link">
         <i class="nav-icon fa fa-shopping-cart"></i>
         <p>الطلبات</p>
       </a>
    </li>
    <li class="nav-item">
      <a href="{{url(route('user.change-password'))}}" class="nav-link">
        <i class="nav-icon fa fa-lock"></i>
        <p>تغيير كلمة المرور</p>
      </a>
   </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('content')
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <strong>CopyLeft &copy; 2020 سفرة</strong>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- SlimScroll -->
<script src="{{asset('adminlte/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('adminlte/plugins/fastclick/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('adminlte/js/adminlte.min.js')}}"></script>
<!--select2-->
<script src="{{asset('select2/dist/js/select2.min.js')}}"></script>

<!-- AdminLTE for demo purposes -->
<script src="{{asset('adminlte/js/demo.js')}}"></script>
@stack('scripts')

</body>
</html>
