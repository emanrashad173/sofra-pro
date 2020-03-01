@extends('front.master')
@section('content')
    <!-- Start Offers Section -->

    <section class="offers">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h1>العروض المتاحه الان</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <a href="{{url('restaurant/new-offer')}}" class="btn minu-btn my-5 px-5">اضف عرضا جديداً</a>
                </div>
            </div>
            <div class="row">
              @foreach($offers as $offer)
                <div class="col-sm-6">
                  <div class="closed">
                    {!! Form::open([
                      'url' => 'restaurant/offer-delete/'.$offer->id,
                      'method' => 'delete'
                    ])!!}
                      <button type="submit" style="border:none; background-color:transparent;"><i class="fas fa-times-circle"></i></button>
                    {!! Form::close()!!}
                  </div>
                  <a href="#"><img src="{{asset($offer->image)}}" alt="" width="100%"></a>
                  <div class="item-holder">
                    <div class="features">
                      <a href="{{url('restaurant/edit-offer/' .$offer->id)}}"  style="width:100px;height:45px;margin-right:200px;padding-top:10px"class="d-block">تعديل</a>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
        </div>
    </section>

    <!-- Start Offers Section -->

  @endsection
