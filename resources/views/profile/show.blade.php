<x-main-layout title="1000 أمل لأبناء الشهداء">

    <section class="mt-1">

        <x-alert name="success" />
        <x-alert name="danger" />


        {{-- section header component --}}
        {{-- description=" في هذا القسم يمكنك عرض بيانات جمعية ({{$association->name}}) في النظام . " --}}
        {{-- <x-header1 title=" عرض تفاصيل اليتيم " description=" في هذا القسم يمكنك عرض تفاصيل اليتيم ({{$orphan->name}}) في النظام . "/> --}}

        <div class="rounded mt-3 ms-2 me-2" style="border-top-color:#f0fff4 !important">

            <div class="row background border rounded p-3">

                <div class="col-12 col-sm-6 col-md-6  mb-3">
                    <span class="fw-bold"> الاسم: </span>
                    <span class="value"> {{ $user->name }} </span>
                </div>

                <div class="col-12 col-sm-6 col-md-6  mb-3">
                    <span class="fw-bold"> البريد الالكتروني: </span>
                    <span class="value"> {{ $user->email }} </span>
                </div>

                <div class="col-12 col-sm-6 col-md-6  mb-3">
                    <span class="fw-bold"> رقم الهاتف: </span>
                    <span class="value"> {{ $user->phone }} </span>
                </div>

                @auth('web')



                @endauth

                @auth('association')



                    <div class="col-12 col-sm-6 col-md-6  mb-3">
                        <span class="fw-bold"> العنوان: </span>
                        <span class="value"> {{ $user->address }} </span>
                    </div>

                    <div class="col-12 col-sm-6 col-md-6  mb-3">
                        <span class="fw-bold"> الشخص المسؤول: </span>
                        <span class="value"> {{ $user->responsible_person }} </span>
                    </div>



                    <div class="col-12 col-sm-6 col-md-6  mb-3">
                        <span class="fw-bold">  الفاكس: </span>
                        <span class="value"> {{ $user->fax }} </span>
                    </div>



                @endauth

                @auth('researcher')



                    <div class="col-12 col-sm-6 col-md-6  mb-3">
                        <span class="fw-bold">رقم الهوية: </span>
                        <span class="value"> {{ $user->id_number }} </span>
                    </div>



                    <div class="col-12 col-sm-6 col-md-6  mb-3">
                        <span class="fw-bold">رقم الجوال واتس: </span>
                        <span class="value"> {{ $user->phone_whats }} </span>
                    </div>

                @endauth

                @auth('sponsor')




                    <div class="col-12 col-sm-6 col-md-6  mb-3">
                        <span class="fw-bold"> الدولة: </span>
                        <span class="value"> {{ $user->country }} </span>
                    </div>


                    <div class="col-12 col-sm-6 col-md-6  mb-3">
                        <span class="fw-bold"> العنوان: </span>
                        <span class="value"> {{ $user->address }} </span>
                    </div>


                    <div class="col-12 col-sm-6 col-md-6  mb-3">
                        <span class="fw-bold"> الحصول على تقارير دورية: </span>
                        <span class="value">
                            <input class="form-check-input" type="checkbox" role="switch" id="switchCheckChecked1" @checked($user->receive_report =="yes")>

                            {{-- {{ $user->receive_report }}  --}}
                        </span>
                    </div>



                    <div class="col-12 col-sm-6 col-md-6  mb-3">
                        <span class="fw-bold">  تذكبر بالدفع: </span>
                        <span class="value">
                            <input class="form-check-input" type="checkbox" role="switch" id="switchCheckChecked2" @checked($user->payment_reminder =="yes")>
                             {{-- {{ $user->payment_reminder }} --}}
                        </span>
                    </div>

                @endauth



            </div>

        </div>

    </section>

</x-main-layout>
