<x-main-layout title="1000 أمل لأبناء الشهداء">

    <section class="mt-1">

        <x-alert name="success" />
        <x-alert name="danger" />



        {{-- section header component --}}
        {{-- description=" في هذا القسم يمكنك عرض بيانات جمعية ({{$association->name}}) في النظام . " --}}
        <x-header1 title=" عرض تفاصيل الجمعية " description=" في هذا القسم يمكنك عرض تفاصيل جمعية ({{$association->name}}) في النظام . "/>

        <div class="rounded mt-3 ms-2 me-2" style="border-top-color:#f0fff4 !important">

            <div class="row background border rounded p-3">

                <div class="col-12 col-sm-6 col-md-6 col-lg-5 mb-3">
                    <span class="fw-bold"> اسم الجمعية: </span>
                    <span class="value"> {{$association->name}} </span>
                </div>

                <div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-3">
                    <span class="fw-bold">  العنوان: </span>
                    <span class="value"> {{$association->address}} </span>
                </div>

                <div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-3">
                    <span class="fw-bold"> الشخص المسؤول : </span>
                    <span class="value"> {{$association->responsible_person}} </span>
                </div>

                <div class="col-12 col-sm-6 col-md-6 col-lg-5 mb-3">
                    <span class="fw-bold"> البريد الالكتروني:</span>
                    <span class="value"> {{$association->email}} </span>
                </div>

                <div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-3">
                    <span class="fw-bold">  الفاكس: </span>
                    <span class="value"> {{$association->fax}} </span>
                </div>

                <div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-3">
                    <span class="fw-bold"> رقم الترخيص:</span>
                    <span class="value"> {{$association->license_number}} </span>
                </div>


                <div class="col-12 col-sm-6 col-md-6 col-lg-5 mb-3">
                    <span class="fw-bold">  رقم الهاتف: </span>
                    <span class="value"> {{$association->phone}} </span>
                </div>

                <div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-3">
                    <span class="fw-bold"> رقم الهاتف 1  : </span>
                    <span class="value"> {{$association->phone1}} </span>
                </div>

                <div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-3">
                    <span class="fw-bold"> رقم الهاتف 2  : </span>
                    <span class="value"> {{$association->phone2}} </span>
                </div>



            </div>

        </div>

    </section>

</x-main-layout>
