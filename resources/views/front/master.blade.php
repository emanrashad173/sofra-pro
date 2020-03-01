<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap.min.css"
        integrity="sha384-vus3nQHTD+5mpDiZ4rkEPlnkcyTP+49BhJ4wJeJunw06ZAp+wzzeBPUXr42fi8If" crossorigin="anonymous">
    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="{{asset('front/css/style.css')}}">
    <!-- Custom fonts  -->
    <link href="https://fonts.googleapis.com/css?family=Cairo:400,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
        integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <title>Sofra</title>
</head>

<body>

    <!--==============navbar section=======-->
    <div class="container-fluid">
        <div class="row">
            <nav class="navbar navbar-light" style="background-color: #ECECEC;">
                <div class="col-md-4 col-sm-12">
                  @auth('web-client')
                  <a href="{{url('client/cart')}}"><i class="fas fa-shopping-cart"></i></a>
                    <div class="dropdown">
                        <i class="fas fa-user-circle dropbtn "></i>
                        <div class="dropdown-content">
                            <a href="{{url('client/profile-client')}}">معلوماتي</a>
                            <a href="{{url('client/my-orders')}}">طلباتي</a>
                            <a href="{{url('/contact')}}">تواصل معانا</a>
                            <a href="{{url('client/logout')}}">خروج</a>
                        </div>
                    </div>
                    @endauth
                </div>


                <div class="col-md-4 col-sm-12 logo-up">
                    <img class="logo" src="{{asset('front/images/sofra%20logo-1@2x.png')}}">
                </div>
                <div class="col-md-4 col-sm-12">
                  @auth('web-restaurant')
                    <div class="dropdown"  style="margin-right:70%" >
                        <i class="fas fa-hamburger"></i>
                        <div class="dropdown-content">
                            <a href="{{url('restaurant/profile-restaurant')}}">بياناتي</a>
                            <a href="{{url('restaurant/new-orders')}}">طلباتي</a>
                            <a href="{{url('restaurant/products')}}">منتجاتي</a>
                            <a href="{{url('restaurant/offers')}}">عروضي</a>
                            <a href="{{url('/contact')}}">تواصل معانا</a>
                            <a href="{{url('restaurant/logout')}}">خروج</a>
                        </div>
                    </div>
                    @endauth
                  </div>
            </nav>
        </div>
    </div>

    <!--content--->
    @yield('content')
    <!--content--->
   <!--footer-->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="footer-desc">
                        <div class="who-us">
                            <i class="fa fa-pencil"></i>
                            <h3>من نحن</h3>
                        </div>
                        <p>{{$settings->about_app}}</p>
                        <ul class="list-unstyled links">
                            <li>
                                <a href="#" class="fab fa-facebook-square"></a>
                            </li>
                            <li>
                                <a href="#" class="fab fa-twitter"></a>
                            </li>
                            <li>
                                <a href="#" class="fab fa-instagram"></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <a href="index.html" class="footer-logo">
                        <img src="{{asset('front/images/sofra logo-1.png')}}" alt="Footer-logo">
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{asset('front/js/jquery-3.3.1.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    @stack('scripts')

</body>

</html>
