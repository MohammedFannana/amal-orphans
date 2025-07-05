<x-main-layout title="1000 أمل لأبناء الشهداء">

    @push('styles')

        <style>

        </style>

    @endpush


    {{-- family information section --}}
    <section class="family-information mt-1">

        <x-alert name="success" />
        <x-alert name="danger" />



        {{-- section header component --}}
        <x-header1 title=" إضافة باحث " description=" في هذا القسم يمكنك إضافة باحث جديد إلى النظام من خلال تعبئة البيانات الأساسية . يرجى التأكد من صحة البيانات قبل الحفظ. "/>


        <div class="border border-1 rounded mt-3" style="border-top-color:#f0fff4 !important">

            <div class="m-4 row">


                <form action="{{route('association.researcher.store')}}" method="post" enctype="multipart/form-data">
                    @csrf

                    @include('associations.researchers._form' , [
                            'button' => __('حفظ الباحث')])

                </form>

            </div>

        </div>

    </section>

</x-main-layout>
