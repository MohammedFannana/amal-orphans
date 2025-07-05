<x-main-layout title="1000 أمل لأبناء الشهداء">

    <section class="mt-1">

        <x-alert name="success" />
        <x-alert name="danger" />



        {{-- section header component --}}
        <x-header1 title=" القرارات والمراجعات " description=" في هذا القسم يمكنك إضافة مراجعة الأيتام في النظام من خلال تعبئة البيانات الأساسية . يرجى التأكد من صحة البيانات قبل الحفظ. "/>

        <div class="rounded mt-3" style="border-top-color:#f0fff4 !important">

            <div class="mt-4 mb-4 row">

                <form action="{{ auth('association')->check() ? route('association.orphan.review') : route('researcher.orphan.review') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="orphan_id" value="{{$orphan->id}}">

                    <div class="flex flex-column  mb-4">
                        <p class="fw-semibold mb-1"> {{__('حالة الملف')}}</p>

                        <div class="d-flex gap-5" >

                            <div class="d-flex gap-1">
                                <input type="radio" name="status" id="rejected" value="rejected">
                                <label for="rejected"  class="title">{{__('الملف مرفوض')}}</label>
                            </div>

                            <div class="d-flex gap-1">
                                <input type="radio" name="status" id="approved" value="approved">
                                <label for="approved" class="title">{{__('الملف مقبول')}}</label>
                            </div>

                        </div>
                    </div>

                    <div class="mb-4">
                        <x-form.textarea label="{{__('تقرير المراجع')}}" name="report"  placeholder=" {{__('اكتب تقرير المراجع')}}"/>
                    </div>


                    <div class="mb-4">
                        <x-form.input name="name" class="border" type="text" label=" {{__('اسم المراجع')}}" autocomplete="" placeholder="{{__('أدخل اسم المراجع')}}"
                            value="{{ auth('association')->check() ? auth('association')->user()->name : (auth('researcher')->check() ? auth('researcher')->user()->name : '') }}"

                        />
                    </div>

                    <div class="d-grid gap-2 col-1 mx-auto">
                        <button type="submit" class="submit-btn"> {{__('ارسال')}} </button>
                    </div>




                </form>

            </div>

        </div>

    </section>

</x-main-layout>
