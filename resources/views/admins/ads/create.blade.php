<x-main-layout title="1000 أمل لأبناء الشهداء">

    <section class="mt-1">

        <x-alert name="success" />
        <x-alert name="danger" />



        {{-- section header component --}}
        <x-header1 title=" إضافة إعلان " description=" في هذا القسم يمكنك إضافة إعلان جديد إلى النظام من خلال تعبئة البيانات الأساسية . يرجى التأكد من صحة البيانات قبل الحفظ. "/>

        <div class="rounded mt-3" style="border-top-color:#f0fff4 !important">

            <div class="m-4 row">


                <form action="{{route('admin.ad.store')}}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="col-12 mb-4">

                        <label class="mb-2 fw-bold"> الإعلان </label> <br>
                        <label for="ad" class="custom-file-upload text-center" style="width: 100%;color:#777a78;">
                            <img src="{{asset('images/file.png')}}" alt="" width="50px" height="50px"> ,<br>
                               اضغط لاختيار الصورة
                        </label>
                        <x-form.input name="ad" class="hidden-file-style" type="file" id="ad" style="display: none;"/>
                    </div>


                    <div class="d-flex justify-content-center gap-4 mt-4">
                        <button class="submit-btn mb-4 w-100"  type="submit"> حفظ الإعلان </button>
                    </div>
                </form>

            </div>

        </div>

    </section>

</x-main-layout>
