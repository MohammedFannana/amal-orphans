<x-main-layout title="1000 أمل لأبناء الشهداء">

    <section class="mt-1">

        {{-- section header component --}}
        <x-header1 title=" تعديل بيانات الكافل " description=" في هذا القسم يمكنك تعديل بيانات الكافل ({{$sponsor->name}}) في النظام من خلال تعديل البيانات الأساسية . يرجى التأكد من صحة البيانات قبل التعديل. "/>

        <x-alert name="success" />
        <x-alert name="danger" />

        <div class="rounded mt-3" style="border-top-color:#f0fff4 !important">

            <div class="m-4 row">


                <form action="{{route('admin.sponsor.update' , $sponsor->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    @include('admins.sponsors._form' , [
                            'button' => __(' حفظ التعديلات ')])

                </form>

            </div>

        </div>

    </section>

</x-main-layout>
