<x-main-layout title="1000 أمل لأبناء الشهداء">

    @push('styles')

        <style>
            .color-text{
                color:rgba(36, 36, 36, 0.6);
            }

        </style>

    @endpush


    <div class="header fw-bold" style="color: var(--primary-color);font-size:18px;  border-top-right-radius: 6px;border-top-left-radius:6px; padding:10px;background:linear-gradient(to left , #c6fdda , #edfaf1)">
        مرحبًا بك في لوحة التحكم
        <p class="color-text fw-normal mt-2" style="font-size: 15px">
            من خلال هذه الصفحة يمكنكم عرض إيصال الدفع الخاص بالكفالة، وتحديد المبلغ والمدة، بالإضافة إلى إرفاق رسالة شكر مصورة .
        </p>
    </div>

    <section class="family-information mt-5">

        {{--    --}}


        <div class="rounded">

            <div class="d-flex justify-content-between mb-3">
                <p class="fs-5 fw-semibold"> قائمة المبالغ المدفوعة </p>
                <p class="text-center p-3  fw-semibold " style="background-color: #cbfcdc; font-size:18px"> {{__('الرصيد الكلي')}} :<span class="fs-5 fw-bold" style="color: var(--primary-color)">{{ $expenseAmount }}</span> </p>

            </div>


            <div class="table-responsive">
                <table  class=" border-0 w-100 text-center" style="border-collapse: collapse;">

                    <thead>
                        <tr>
                            <th>#</th>
                            {{-- <th>اسم اليتيم</th> --}}
                            <th> مدة الكفالة </th>
                            <th>مبلغ الكفالة</th>
                            <th> إيصال الدفع </th>
                            <th>  رسالة شكر  </th>
                            <th> صورة تسليم الكفالة </th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($expenses as $expense)

                            <tr>
                                <td> <span class="value"> {{$expense->id}}           </span> </td>
                                {{-- <td><span class="value">  {{$expense->orphan->name}}         </span></td> --}}
                                <td><span class="value">  {{$expense->duration}}    </span></td>
                                <td><span class="value">  {{$expense->bail_amount}}        </span></td>
                                <td>
                                    <span class="value">
                                        <a href="{{route('orphan.primary.image' , ['file' => encrypt($expense->payment_received)])}}" type="button" class="text-decoration-none file-image p-2">
                                            <img src="{{asset('images/elements.png')}}" alt="" width="22px" height="22px" >
                                            إيصال الدفع
                                        </a>
                                    </span>
                                </td>

                                <td>
                                    <span class="value">
                                        <a href="{{route('orphan.primary.video' , ['file' => encrypt($expense->thank_letter_video)])}}" type="button" class="text-decoration-none file-image p-2">
                                            <img src="{{asset('images/video.png')}}" alt="" width="22px" height="22px" >
                                            رسالة شكر
                                        </a>

                                        <br>

                                        @if ($expense->thank_letter_audio)
                                            <span class="value">
                                                <a href="{{route('orphan.primary.audio' , ['file' => encrypt($expense->thank_letter_audio)])}}" type="button" class="text-decoration-none file-image p-2">
                                                    <img src="{{asset('images/audio.png')}}" alt="" width="22px" height="22px" >
                                                    رسالة شكر صوتية
                                                </a>
                                            </span>
                                        @endif

                                    </span>
                                </td>

                                <td>
                                    <span class="value">
                                        <a href="{{route('orphan.primary.image' , ['file' => encrypt($expense->delivery_bail)])}}" type="button" class="text-decoration-none file-image p-2">
                                            <img src="{{asset('images/elements.png')}}" alt="" width="22px" height="22px" >
                                            صورة تسليم الكفالة
                                        </a>
                                    </span>
                                </td>


                            </tr>

                        @empty

                             <tr>
                                <td colspan="7" class="text-center fs-5 rounded text-danger">
                                    {{__('لا يوجد مبالغ مدفوعة في النظام')}}
                                </td>
                            </tr>

                        @endforelse

                    </tbody>
                </table>
            </div>



        </div>

    </section>

    {{$expenses->withQueryString()->links()}}
</x-main-layout>
