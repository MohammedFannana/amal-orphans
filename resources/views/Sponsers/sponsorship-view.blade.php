<x-main-layout title="1000 أمل لأبناء الشهداء">

    @push('styles')

        <style>
            .color-text{
                color:rgba(36, 36, 36, 0.6);
            }

        </style>

    @endpush


    <div class="header fw-bold" style="color: var(--primary-color);font-size:18px;  border-top-right-radius: 6px;border-top-left-radius:6px; padding:10px;background:linear-gradient(to left , #c6fdda , #edfaf1)">
        مرحبًا بك في لوحة الكافلين
        <p class="color-text fw-normal mt-2" style="font-size: 15px">
            يعرض هذا القسم معلومات الأيتام المكفولين ، بما في ذلك بياناتهم الشخصية، مع إمكانية متابعة حالة الكفالة، وتجديدها أو إيقافها حسب الحاجة.
        </p>
    </div>

    <x-alert name="success" />
    <x-alert name="danger" />

    <section class="family-information mt-5">

        <div class="rounded">

            <div class="d-flex justify-content-between mb-3">
                <p class="fs-5 fw-semibold"> قائمة الكفالات الخاصة ب المكفولين </p>
            </div>



            <div class="table-responsive">
                <table  class=" border-0 w-100 text-center" style="border-collapse: collapse;">

                    <thead>
                        <tr>
                            <th>#</th>
                            {{-- <th>اسم اليتيم</th> --}}
                            {{-- <th>  الجنس </th> --}}
                            {{-- <th>  العمر </th> --}}
                            <th>  المبلغ المدفوع</th>
                            <th>  مدة الكفالة </th>
                            <th>  تاريخ بدء الكفالة </th>
                            <th> التاريخ القادم للدفع </th>
                            <th>  حالة الكفالة </th>

                            {{-- <th> الاجراءات </th> --}}
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($sponsorships as $sponsorship)

                            <tr>
                                 @php

                                    $startDate = \Carbon\Carbon::parse($sponsorship->sponsorship_date);
                                    // @dd($startDate);
                                    $endDate = $startDate->copy()->addMonths($sponsorship->duration);
                                @endphp

                                <td> <span class="value"> {{$sponsorship->id}}           </span> </td>
                                {{-- <td><span class="value">  {{$orphan->name}}         </span></td> --}}
                                {{-- <td><span class="value">  {{$orphan->gender}}    </span></td> --}}
                                {{-- <td><span class="value">   {{$age}}  </span></td> --}}

                                <td><span class="value">  {{$sponsorship->bail_amount}}     </span></td>
                                <td><span class="value">  {{$sponsorship->duration}}        </span></td>
                                <td><span class="value">  {{$sponsorship->sponsorship_date}} </span></td>

                                <td><span class="value">  {{ $endDate->format('Y-m-d') }}     </span></td>
                                <td><span class="value">  @if ($sponsorship->status == 'active') فعالة  @else منهية @endif </span></td>


                            </tr>

                        @empty

                             <tr>
                                <td colspan="9" class="text-center fs-5 rounded text-danger">
                                    {{__('لا يوجد أيتام كفالات لهذا اليتيم في النظام')}}
                                </td>
                            </tr>

                        @endforelse

                    </tbody>
                </table>
            </div>



        </div>

    </section>

     {{$sponsorships->withQueryString()->links()}}
</x-main-layout>
