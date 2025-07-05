<!-- to define variable and default variable to pass to components-->
@props([
'name',
'value' => '',
'label' => false,
'placeholder' => '',
])

<!-- {{$attributes}} to echo any un except attribute insert into input -->
<!-- {{$attributes}} to allow insert attributes into input  -->
<div>
    @if($label)
    <label class="mb-3 fw-bold"> {{$label}}</label>
    @endif
    <textarea placeholder="{{$placeholder}}" name="{{$name}}" {{$attributes->class(['form-control' , 'is-invalid' => $errors->has($name)])}} style="height:150px; color:#737373"> {{ old($name , $value ) }} </textarea>
    @error($name)
    <div class="text-danger">
        {{$message}}
    </div>
    @enderror
</div>
