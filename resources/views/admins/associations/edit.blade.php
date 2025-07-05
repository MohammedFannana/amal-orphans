<x-main-layout title="1000 أمل لأبناء الشهداء">

    <section class="mt-1">

        <x-alert name="success" />
        <x-alert name="danger" />



        {{-- section header component --}}
        <x-header1 title=" تعديل بيانات الجمعية " description=" في هذا القسم يمكنك تعديل بيانات جمعية ({{$association->name}}) في النظام من خلال تعديل البيانات الأساسية . يرجى التأكد من صحة البيانات قبل التعديل. "/>

        <div class="rounded mt-3" style="border-top-color:#f0fff4 !important">

            <div class="m-4 row">


                <form action="{{route('admin.association.update' , $association->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    @include('admins.associations._form' , [
                            'button' => __(' حفظ التعديلات  ')])

                </form>

            </div>

        </div>

    </section>

</x-main-layout>
