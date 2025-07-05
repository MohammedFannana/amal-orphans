{{-- @props([
'name'
])

@php

    $class = $name == 'error'? 'danger' : 'success';

@endphp

@if(session()->has($name))
    <div class="alert alert-{{$class}} fade-alert mt-2">
        {{ session($name) }}
    </div>

    <script>
        setTimeout(() => {
            const alertBox = document.querySelector('.fade-alert');
            if (alertBox) {
                alertBox.style.transition = 'opacity 0.5s ease';
                alertBox.style.opacity = '0';
                setTimeout(() => alertBox.remove(), 500); // remove after fade out
            }
        }, 5000);
    </script>

@endif --}}

@props([
    'name'
])

@php
    $type = $name === 'error' ? 'danger' : 'success';
    $icon = $type === 'success'
        ? '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill me-2" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.97 11.03a.75.75 0 0 0 1.07 0l3.992-3.993a.75.75 0 1 0-1.06-1.06L7.5 9.439 6.477 8.415a.75.75 0 0 0-1.06 1.06l1.553 1.553z"/>
          </svg>'
        : '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill me-2" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.646 4.646a.5.5 0 1 0-.708.708L7.293 8l-3.355 3.354a.5.5 0 0 0 .708.708L8 8.707l3.354 3.355a.5.5 0 0 0 .708-.708L8.707 8l3.355-3.354a.5.5 0 0 0-.708-.708L8 7.293 4.646 4.646z"/>
          </svg>';
@endphp

@if(session()->has($name))
    <div class="alert alert-{{ $type }} alert-dismissible fade show d-flex align-items-center" role="alert" style="font-size: 1rem;">
        {!! $icon !!}
        <div>
            {{ session($name) }}
        </div>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <script>
        setTimeout(() => {
            let alertEl = document.querySelector('.alert');
            if (alertEl) {
                let bsAlert = bootstrap.Alert.getOrCreateInstance(alertEl);
                bsAlert.close();
            }
        }, 5000);
    </script>
@endif
