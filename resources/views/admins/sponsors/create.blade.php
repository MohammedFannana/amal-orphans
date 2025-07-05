<x-main-layout title="1000 أمل لأبناء الشهداء">

    <section class="mt-1">


        <x-alert name="success" />
        <x-alert name="danger" />



        {{-- section header component --}}
        <x-header1 title=" إضافة كافل " description=" في هذا القسم يمكنك إضافة كافل جديد إلى النظام من خلال تعبئة البيانات الأساسية . يرجى التأكد من صحة البيانات قبل الحفظ. "/>

        <div class="rounded mt-3" style="border-top-color:#f0fff4 !important">

            <div class="mt-4 mb-4 row">

                <form action="{{route('admin.sponsor.store')}}" method="post" enctype="multipart/form-data">
                    @csrf

                    @include('admins.sponsors._form' , [
                            'button' => __('حفظ البيانات')])

                </form>

            </div>

        </div>

    </section>

</x-main-layout>
