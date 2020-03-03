@extends('front.master')
@section('content')
<head>
   <link rel="stylesheet" href="{{asset('front/css/slick.css')}}">
   <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">
</head>
    <section class="meal-page">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="meal-desc">
                        <h1>{{$product->name}}</h1>
                        <p>{{$product->description}}</p>
                        <p><img src="{{asset('front/images/piggy-bank.png')}}" alt="" width="50px"> السعر : {{$product->price}} ريال</p>
                        <p><img src="{{asset('front/images/piggy-bank.png')}}" alt="" width="50px">مدة تجهيز الطلب : {{$product->preparation_time}} دقيقة</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="meal-img">
                        <img src="{{asset($product->image)}}" alt="meal-img" width="100%" class="meal-img">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Start Cart Section -->
    <section class="add-to-cart-sec">
        <div class="container">
            <a href="{{url('client/add-to-cart/'.$product->id)}}" class="add-to-cart">
                اضف الي العربة
            </a>
        </div>
    </section>
    <!-- End Add Cart Section -->

    <!-- Start More Meals Section -->
    <section class="more-meals">
        <h2>المزيد من أكلات هذا المطعم</h2>
        <div class="meals-imgs">
            <div class="contanier-fluid">
                <div class="slider">
                  @foreach($products as $product)
                    <div class="item">
                        <img src="{{asset($product->image)}}" alt="Meal">
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </section>
    <!-- End More Meals Section -->

    <!-- Optional JavaScript -->
@push('scripts')
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <script src="{{asset('front/js/slick.min.js')}}"></script>
    <script>
        $('.from').datepicker({
            uiLibrary: 'bootstrap4'
        });

        $('.to').datepicker({
            uiLibrary: 'bootstrap4'
        });
    </script>
    <script>
    $('.slider').slick({
        dots: false,
        infinite: true,
        speed: 300,
        slidesToShow: 4,
        autoplay:false,
        slidesToScroll: 1,
        arrows:false,
        rtl:true,
        responsive: [
            {
            breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    infinite: true,
                    dots: false
                }
            },
            {
            breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    });
    </script>
@endpush
@endsection
