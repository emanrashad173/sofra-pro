<div class="col-sm-3">
  {!! Form::select('restaurant_id',App\Models\Restaurant::pluck('name','id')->toArray(),request('restaurant_id'),[
  'class' => 'form-control',
  'placeholder' => 'اختر المطعم'
  ])!!}
</div>

<div class="form-group">
  <label for="name">التاريخ</label>
  {!! Form::date('date' ,null, [
  'class' =>'form-control'
  ])!!}
</div>
<div class="form-group">
  <label for="name">النقود المدفوعة</label>
  {!! Form::text('received_money' ,null, [
  'class' =>'form-control'
  ])!!}
</div>


<div class="form-group">
  <button class="btn btn-primary" type="submit">اضافة</button>
</div>
