<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body{
                background-image:url('../images/background.png') !important;
                background-size: cover !important;
                background-repeat: no-repeat !important;
                /* background: linear-gradient(to right, #d4f9e2 ,  white); */
            }

            .background1{
                background-color: white !important;
            }

            .bg-selected {
                background-color: #bbf7d0 !important;
            }
        </style>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.rtl.min.css" integrity="sha384-q8+l9TmX3RaSz3HKGBmqP2u5MkgeN7HrfOJBLcTgZsQsbrx8WqqxdA5PuwUV9WIx" crossorigin="anonymous">
        <link rel="stylesheet" href="{{asset('css/style.css')}}">
    </head>
    <body class="font-sans text-gray-900 antialiased" dir="rtl">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="d-flex gap-4 mb-4">
                    {{-- <x-application-logo class="w-20 h-20 fill-current text-gray-500" /> --}}
                <img src="{{asset('images/logo2.png')}}" alt="">
                <img src="{{asset('images/logo.png')}}" alt="">

            </div>

            <div class="w-full sm:max-w-2xl mt-6 mb-4 shadow-md overflow-hidden sm:rounded-lg"  style="background-color: rgba(255, 255, 255, 0.61) ; border-radius:30px ; padding:70px">
                {{ $slot }}
            </div>
        </div>
    </body>

    @stack('script')
</html>
