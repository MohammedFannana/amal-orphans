<x-main-layout title="1000 أمل لأبناء الشهداء">

    <section class="mt-1">

        <x-alert name="success" />
        <x-alert name="danger" />



        {{-- section header component --}}
        <x-header1 title=" إضافة جمعية " description=" في هذا القسم يمكنك إضافة جمعية جديدة إلى النظام من خلال تعبئة البيانات الأساسية . يرجى التأكد من صحة البيانات قبل الحفظ. "/>

        <div class="rounded mt-3" style="border-top-color:#f0fff4 !important">

            <div class="m-4 row">


                <form action="{{route('admin.association.store')}}" method="post" enctype="multipart/form-data">
                    @csrf

                    @include('admins.associations._form' , [
                            'button' => __('حفظ الجمعية')])

                </form>

            </div>

        </div>

    </section>

</x-main-layout>
