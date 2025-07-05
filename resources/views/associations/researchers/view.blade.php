<x-main-layout title="1000 أمل لأبناء الشهداء">

    <section class="mt-1">

        <x-alert name="success" />
        <x-alert name="danger" />



        {{-- section header component --}}
        {{-- description=" في هذا القسم يمكنك عرض بيانات جمعية ({{$association->name}}) في النظام . " --}}
        <x-header1 title=" عرض تفاصيل الباحث " description=" في هذا القسم يمكنك عرض تفاصيل الباحث ({{$researcher->name}}) في النظام . "/>

        <div class="rounded mt-3 ms-2 me-2" style="border-top-color:#f0fff4 !important">

            <div class="row background border rounded p-3">

                <div class="col-12 col-sm-6 col-md-6  mb-4">
                    <span class="fw-bold"> اسم الباحث: </span>
                    <span class="value"> {{$researcher->name}} </span>
                </div>


                <div class="col-12 col-sm-6 col-md-6  mb-4">
                    <span class="fw-bold"> البريد الالكتروني:</span>
                    <span class="value"> {{$researcher->email}} </span>
                </div>


                <div class="col-12 col-sm-6 col-md-6  mb-4">
                    <span class="fw-bold">  رقم الهوية: </span>
                    <span class="value"> {{$researcher->id_number}} </span>
                </div>

                <div class="col-12 col-sm-6 col-md-6  mb-4">
                    <span class="fw-bold"> رقم الجوال:</span>
                    <span class="value"> {{$researcher->phone}} </span>
                </div>


                <div class="col-12 col-sm-6 col-md-6  mb-4">
                    <span class="fw-bold"> رقم الجوال واتس: </span>
                    <span class="value"> {{$researcher->phone_whats}} </span>
                </div>


            </div>

        </div>

    </section>

</x-main-layout>
