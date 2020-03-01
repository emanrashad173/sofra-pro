@extends('front.master')
@section('content')
<head>
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
</head>
<style>
div.stars {
  width: 270px;
  display: inline-block;
}

input.star { display: none;}

label.star {
  float: right;
  padding: 10px;
  font-size: 36px;
  color: #444;
  transition: all .2s;

}

input.star:checked ~ label.star:before {
  content: '\f005';
  color: #ec3454;
  transition: all .25s;
}

input.star-5:checked ~ label.star:before {
  color: #ec3454;
  text-shadow: 0 0 20px #952;
}

input.star-1:checked ~ label.star:before { color: #ec3454; }

label.star:hover { transform: rotate(-15deg) scale(1.3); }

label.star:before {
  content: '\f006';
  font-family: FontAwesome;
}
</style>
<!--==============First section=======-->
<section id="header">
    <div class="container">
        <div class="header-desc">
            <img class="website-name" src="" alt="" style="margin: 0 auto;">
            <h1 class="res-name"></h1>
            <ul class="list-unstyled">
                <li class="fa fa-star"></li>
                <li class="fa fa-star"></li>
                <li class="fa fa-star"></li>
                <li class="fa fa-star"></li>
                <li class="fa fa-star"></li>
            </ul>
        </div>
    </div>
</section>
<section class="add-to-cart-sec">
    <div class="container">
      <div class="add-rate" style="margin-bottom:50px;">
          <h2>التقييم و التعليقات</h2>
      </div>
      @foreach($comments->chunk(2) as $chunk)
      <div class="row">
        @foreach($chunk as $comment)
          <div class="col-md-6">
              <div class="rate-com">
                <ul class="list-unstyled">
                  @for($i = 1; $i<=5; $i++)
                    <li class="@if($comment->rating >= $i) active @endif">
                        <i class="fa fa-star"></i>
                    </li>
                  @endfor
                </ul>
                  <h3>بواسطة : {{$comment->client->name}}</h3>
                  <p>{{$comment->content}}</p>
              </div>
          </div>
          @endforeach
      </div>
      @endforeach
      <!-- Add Rate To Service -->

      <div class="add-rate">
          <h2>اضف تقييمك</h2>
          @inject('model','App\Models\Comment')
          {!! Form::model($model,[
            'url' =>'client/create-comment/'.Request::route('restaurant'),
            'method' => 'post',
            ])!!}
          <div class="form-group  buttons stars" style="margin-right:430px;">
            <input class="star star-5" id="star-5" type="radio" name="rating" value="5"/>
            <label class="star star-5" for="star-5"></label>
            <input class="star star-4" id="star-4" type="radio" name="rating" value="4"/>
            <label class="star star-4" for="star-4"></label>
            <input class="star star-3" id="star-3" type="radio" name="rating" value="3"/>
            <label class="star star-3" for="star-3"></label>
            <input class="star star-2" id="star-2" type="radio" name="rating" value="2"/>
            <label class="star star-2" for="star-2"></label>
            <input class="star star-1" id="star-1" type="radio" name="rating" value="1"/>
            <label class="star star-1" for="star-1"></label>
         </div>

              {!! Form::textarea('content' ,null, [
              'rows' => '10',
              'cols' => '30',
               'id' => 'rate' ,
              'placeholder'=> 'اضف تقييمك'
              ])!!}
              @error('message')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
              <input type="submit" value="ارسال" name="submit">
      </div>
      {!! Form::close() !!}
    </div>
  </section>
  <!-- End Add Cart Section -->
@endsection
