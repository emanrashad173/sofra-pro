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
            @foreach($offers->chunk(2) as $chunk)
            <div class="row">
              @foreach($chunk as $offer)
                <div class="col-sm-6"><a href="#"><img src="{{$offer->image}}" alt="" width="100%"></a></div>
              @endforeach
            </div>
            @endforeach
        </div>
    </section>

    <!-- Start Offers Section -->
@endsection
