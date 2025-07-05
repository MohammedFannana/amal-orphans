<x-main-layout title="1000 أمل لأبناء الشهداء">

    @push('styles')

        <style>

        </style>

    @endpush


    {{-- family information section --}}
    <section class="family-information mt-5">

        {{-- section header component --}}
        <x-header1 title=" تعديل بيانات الباحث " description=" في هذا القسم يمكنك تعديل بيانات الباحث ({{$researcher->name}}) في النظام من خلال تعديل البيانات الأساسية . يرجى التأكد من صحة البيانات قبل التعديل. "/>

        <x-alert name="success" />
        <x-alert name="danger" />

        <div class="border border-1 rounded mt-3" style="border-top-color:#f0fff4 !important">

            <div class="m-4 row">


                <form action="{{route('association.researcher.update' , $researcher->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    @include('associations.researchers._form' , [
                            'button' => __('حفظ التعديلات')])

                </form>

            </div>

        </div>

    </section>

</x-main-layout>
