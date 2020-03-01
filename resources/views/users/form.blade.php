@inject('role' ,'App\Models\Role')
<?php
$roles =$role ->pluck('display_name','id')->toArray();
 ?>
<div class="form-group">
  <label for="name">الاسم</label>
  {!! Form::text('name' ,null, [
  'class' =>'form-control'
  ])!!}
</div>
<div class="form-group">
  <label for="email">البريد الاليكتروني</label>
  {!! Form::text('email' ,null, [
  'class' =>'form-control'
  ])!!}
</div>
<div class="form-group">
  <label for="password">كلمة المرور</label>
  {!! Form::password('password', [
  'class' =>'form-control'
  ])!!}
</div>
<div class="form-group">
  <label for="password_confirmation">تاكيد كلمة المرور</label>
  {!! Form::password('password_confirmation' , [
  'class' =>'form-control'
  ])!!}
</div>
<div class="form-group">
  <label for="role_list">الرتبة</label>
  <select class="form-control select" name="roles_list[]" value="$roles" multiple="multiple">
    @foreach($role->all() as $rolee)
    <option value="{{$rolee->id}}"
      @if(old('role'))
      selected
      @endif> {{$rolee->display_name}}</option>
    @endforeach

  </select>

</div>


<div class="form-group">
</div>
<button class="btn btn-primary" type="submit">حفظ</button>
@push('scripts')
<script>
  $(document).ready(function() {
      $('.select').select2({
        placeholder : "اختر الرتبة"
      });
  });
</script>
@endpush
