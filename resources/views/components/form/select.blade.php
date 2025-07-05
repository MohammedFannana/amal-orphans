<!-- to define variable and default variable to pass to components-->
@props([
'name',
'options' => [],
'selected' =>null,
'label' => false,
])

@if($label)
    <label class="mb-2 fw-bold"> {{$label}}</label>
@endif


<select name="{{$name}}" {{$attributes->class(['form-control','form-select','is-invalid'=> $errors->has($name)]) }} style="border-radius: 0.375rem;    border-color: rgb(209 213 219);">

    @foreach($options as $value => $text)
    <option value="{{ $value }}" @selected($value==$selected)> {{$text}} </option>
    @endforeach
</select>

@error($name)
    <div class="text-danger">
        {{$message}}
    </div>
@enderror
