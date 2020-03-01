<ul class="list-unstyled stars">
  @for($i = 1; $i<=5; $i++)
    <li class="@if($restaurant->rate >= $i) active @endif">
        <i class="fa fa-star"></i>
    </li>
  @endfor
</ul>
