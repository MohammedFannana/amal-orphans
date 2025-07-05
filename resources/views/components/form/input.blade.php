@props([
    'type' => 'text',
    'name',
    'value' => '',
    'label' => false,
    'placeholder' => false,
])

<div>
    @if($label)
        <label class="mb-2 fw-bold"> {{$label}}</label>
    @endif

    @php
        $isTextInput = in_array($type, ['text', 'email', 'number', 'password', 'date']);
        $defaultClasses = $isTextInput ? ['form-control' , 'text-start'] : [];
        if ($errors->has($name)) {
            $defaultClasses[] = 'is-invalid';
        }
    @endphp

    <input
        type="{{$type}}"
        name="{{$name}}"
        placeholder="{{$placeholder}}"
        value="{{ old($name ,$value ) }}"
        {{ $attributes->class($defaultClasses) }}
    >

    @error($name)
        <div class="text-danger">
            {{$message}}
        </div>
    @enderror
</div>
