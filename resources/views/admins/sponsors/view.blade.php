<x-main-layout title="1000 أمل لأبناء الشهداء">

    <section class="mt-1">

        <x-alert name="success" />
        <x-alert name="danger" />



        {{-- section header component --}}
        {{-- description=" في هذا القسم يمكنك عرض بيانات جمعية ({{$association->name}}) في النظام . " --}}
        <x-header1 title=" عرض تفاصيل الكافل " description=" في هذا القسم يمكنك عرض تفاصيل الكافل ({{$sponsor->name}}) في النظام . "/>

        <div class="rounded mt-3 ms-2 me-2" style="border-top-color:#f0fff4 !important">

            <div class="row background border rounded p-3">

                <div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-3">
                    <span class="fw-bold"> اسم الكافل: </span>
                    <span class="value"> {{$sponsor->name}} </span>
                </div>

                <div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-3">
                    <span class="fw-bold">  رقم الجوال: </span>
                    <span class="value"> {{$sponsor->phone}} </span>
                </div>

                <div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-3">
                    <span class="fw-bold"> البريد الالكتروني : </span>
                    <span class="value"> {{$sponsor->email}} </span>
                </div>

                <div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-3">
                    <span class="fw-bold"> البلد:</span>
                    <span class="value"> {{$sponsor->country}} </span>
                </div>

                <div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-3">
                    <span class="fw-bold">  العنوان: </span>
                    <span class="value"> {{$sponsor->address}} </span>
                </div>

                <div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-3">
                    <span class="fw-bold"> آلية الدفع: </span>
                    <span class="value"> @if ($sponsor->payment_mechanism == 'bank') البنك @else {{$sponsor->payment_mechanism}} @endif </span>
                </div>

                <div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-3">
                    <span class="fw-bold">  تلقي تذكير بالدفع:</span>
                    <span class="value"> @if ($sponsor->payment_reminder == 'no') لا @else نعم @endif </span>
                </div>

                <div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-3">
                    <span class="fw-bold">   الحصول على تقارير دورية : </span>
                    <span class="value"> @if ($sponsor->receive_report == 'no') لا @else نعم @endif </span>
                </div>

            </div>

        </div>

    </section>

</x-main-layout>
