<x-main-layout title="1000 أمل لأبناء الشهداء">

    <section class="mt-1">

        <x-alert name="success" />
        <x-alert name="danger" />



        {{-- section header component --}}
        <x-header1 title=" إضافة كفالة " description=" في هذا القسم يمكنك إضافة كفالة جديدة إلى النظام من خلال تعبئة البيانات الأساسية . يرجى التأكد من صحة البيانات قبل الحفظ. "/>



        <div class="rounded mt-3" style="border-top-color:#f0fff4 !important">

            <div class="m-4 row">


                <form action="{{route('sponsor.orphan.store')}}" method="post" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="orphan_id" value="{{$orphan->id}}">

                   <div class="col-12  mb-4">
                        <x-form.input name="duration"  type="number" id="duration" label=" مدة الكفالة (بالأشهر) " placeholder="ادخل مدة الكفالة" min="1" />
                    </div>

                    <div class="col-12  mb-4">
                        <x-form.input name="bail_amount" type="number" id="bail_amount" label=" مبلغ الكفالة (بالشهر) " placeholder="ادخل مبلغ الكفالة" min="1"/>
                    </div>

                    <div class="col-12 col-md-6 mb-4">

                            <label class="mb-2 fw-bold">  إيصال الدفع </label> <br>
                            <label for="payment_received" class="custom-file-upload text-center" style="width: 90%;color:#777a78;">
                                <img src="{{asset('images/file.png')}}" alt="" width="50px" height="50px"> ,<br>
                                اسحب الملف هنا أو اضغط لاختياره
                            </label>
                            <x-form.input name="payment_received" class="hidden-file-style" type="file" id="payment_received" style="display: none;"/>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="submit-btn w-25"> اكفل الآن </button>
                    </div>

                </form>

            </div>

        </div>

    </section>

</x-main-layout>
