<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.rtl.min.css" integrity="sha384-q8+l9TmX3RaSz3HKGBmqP2u5MkgeN7HrfOJBLcTgZsQsbrx8WqqxdA5PuwUV9WIx" crossorigin="anonymous">
    <title>تسجيل اليتيم</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <style>
        nav{
            background-image: url('../images/background-nav.png');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            background-color: #d0efda;
        }

        .radio-input{
            width: 23px;
            height:23px
        }


        .radio-input:checked{
            background-color: var('--primary-color');
            border-color: var('--primary-color');
        }



        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        th {
            background-color: #dff5e1;
            padding: 10px;
        }

        td {
            padding: 10px;
        }

        tbody tr{
            background-color: #fbfbfb
        }

        table input {
            padding: 5px;
            width: 90%;
            border: 1px solid #ddd;

        }


    </style>

</head>
<body dir="rtl" style="background-color: #f0fff4">

    <div style="ps-4 pe-4">

        <nav class="d-flex align-items-center p-2">

            <div class="d-flex gap-2 align-items-center ps-3">
                <img src="{{asset('images/logo.png')}}" alt="" width="51px" height="70px">
                <img src="{{asset('images/logo2.png')}}" alt="" width="64px" height="56px">
            </div>

            <div class="fw-bold m-auto" style="color: var(--primary-color); font-size:20px">
                عرض  بيانات الأيتام الجاهزين للكفالة
            </div>

        </nav>

        <div class="mt-1 bg-white" style="margin-right:2rem; margin-left:2rem;border-radius:15px">

            <main style="margin-right: 2rem;margin-left:2rem;padding-top:25px;padding-bottom:25px">

                <x-alert name="success"/>
                <x-alert name="danger"/>



                <div class="rounded mt-3 ms-2 me-2 " style="border-top-color:#f0fff4 !important">

                    @forelse ($orphans as $orphan)

                        <div class="row background border rounded p-3 mb-1">

                            <div class="col-sm-12 col-md-4 col-lg-3 d-flex justify-content-between">
                                @if ($orphan->gender === "ذكر")

                                    <img src="{{asset('images/boy.jpg')}}" alt="" width="149px" height="149px">

                                @elseif ($orphan->gender === "أنثى")

                                    <img src="{{asset('images/girl.png')}}" alt="" width="149px" height="149px">

                                @endif
                            </div>

                            <div class="col-sm-12 col-md-8 col-lg-9 ps-2">
                                <div class="mb-3 d-flex justify-content-between align-items-center">
                                    <p class="fw-bold fs-5"> {{ collect(explode(' ', $orphan->name))->take(2)->implode(' ') }} </p>
                                    <a href="{{route('sponsor.orphan.create' , $orphan->id)}}" class="text-decoration-none submit-btn" style="padding: 5px 15px !important"> اكفل الآن </a>
                                </div>

                                <div class="row">

                                    <div class="col-12 col-sm-6 col-md-6  mb-3">
                                        <span class="fw-bold"> حالة اليتيم: </span>
                                        <span class="value"> {{ $orphan->orphan_status }} </span>
                                    </div>


                                    <div class="col-12 col-sm-6 col-md-6  mb-3">
                                        <span class="fw-bold"> تاريخ الميلاد : </span>
                                        <span class="value"> {{ $orphan->birth_date }} </span>
                                    </div>

                                    @php

                                        $birthDate =  \Carbon\Carbon::parse($orphan->birth_date);
                                        $age = $birthDate->age;

                                    @endphp

                                    <div class="col-12 col-sm-6 col-md-6  mb-3">
                                        <span class="fw-bold"> العمر : </span>
                                        <span class="value"> {{ $age }} </span>
                                    </div>

                                    <div class="col-12 col-sm-6 col-md-6  mb-3">
                                        <span class="fw-bold">   الجنس: </span>
                                        <span class="value"> {{ $orphan->gender }}</span>
                                    </div>


                                </div>


                            </div>

                        </div>

                    @empty

                        <div class="p-3 fs-6 fw-semibold  rounded w-100" style="background:linear-gradient(to left , #c6fdda , #edfaf1)">
                            عذرًا، لا أيتام بانتظار الكفالة
                        </div>

                    @endforelse


                </div>


            </main>

        </div>


    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <script src="{{asset('js/script.js')}}"></script>

</body>
</html>
