@props([
    'title',
    'description' => ''
])

<div class="header fw-bold text-center" style="color: var(--primary-color);font-size:18px; border-radius: 6px; padding:10px;background:linear-gradient(to left , #c6fdda , #edfaf1)">
    {{$title}}
    <p style=" color:rgba(36, 36, 36, 0.6);" class="fw-normal fs-6">{{$description}}</p>
</div>
