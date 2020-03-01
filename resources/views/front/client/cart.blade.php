@extends('front.master')
@section('content')
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <!-- Custom styles for this template -->

    <!-- End Navbar Section -->

    <section class="cart">
        <div class="container">
          @foreach($products as $product)
            <div class="row">
                <div class="col-sm-6 offset-sm-3">
                    <div class="cart-item">
                        <div class="row">
                            <div class="col-sm-5">
                                <img src="{{asset($product->image)}}" alt="">
                            </div>
                            <div class="col-sm-7">
                                <p>{{ $product->name}}</p>
                                <p>{{ $product->price }}ريال</p>
                                <p>البائع : {{optional($product->restaurant)->name}}</p>
                                <p>الكيمه : <span>{{ $product->pivot->quantity }}</span></p>
                                <a href="{{url('client/product-remove/' .$product->id)}}" class="add-new-link"><span class="cricle">X</span> امسح</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          @endforeach
        </div>
        <div class=" row item-holder">
          <div class="col-sm-6 features">
            <a href="{{url('/restaurant-page/'.$product->restaurant_id)}}" class="d-block" style="width:40%;margin-right:20%;">اضافة المزيد</a>
          </div>
          <div class="col-sm-6 features">
            <a href="{{url('client/new-order/'.$product->pivot->order_id)}}" class="d-block" style="width:40%;margin-right:20%;">تاكيد الطلب</a>
          </div>
       </div>
    </section>

 @push('scripts')
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <script>
        $('.from').datepicker({
            uiLibrary: 'bootstrap4'
        });

        $('.to').datepicker({
            uiLibrary: 'bootstrap4'
        });
    </script>
  @endpush
@endsection
