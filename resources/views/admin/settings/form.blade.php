<div class="form-group">
  <label for="about_app">عن التطبيق</label>
  {!! Form::text('about_app' ,null, [
  'class' =>'form-control'
  ])!!}
</div>
<div class="form-group">
  <label for="commission">العمولات</label>
  {!! Form::text('commission' ,null, [
  'class' =>'form-control'
  ])!!}
</div>
<div class="form-group">
  <label for="commission_text">النص الخاص بالعمولات</label>
  {!! Form::text('commission_text' ,null, [
  'class' =>'form-control'
  ])!!}
</div>
<div class="form-group">
  <label for="payment_bank">البنك</label>
  {!! Form::text('payment_bank' ,null, [
  'class' =>'form-control'
  ])!!}
</div>
<div class="form-group">
  <button class="btn btn-primary" type="submit">تعديل</button>
</div>
