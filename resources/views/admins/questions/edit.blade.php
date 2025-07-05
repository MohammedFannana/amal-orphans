<x-main-layout title="1000 أمل لأبناء الشهداء">

    <section class="mt-1">

        <x-alert name="success" />
        <x-alert name="danger" />



        {{-- section header component --}}
        <x-header1 title=" تعديل السؤال " description=" في هذا القسم يمكنك تعديل بيانات سؤال  في النظام من خلال تعبئة البيانات الأساسية . يرجى التأكد من صحة البيانات قبل الحفظ. "/>



        <div class="rounded mt-3" style="border-top-color:#f0fff4 !important">

            <div class="m-4 row">


                <form action="{{route('admin.question.update' , $question->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                   <div class="col-12  mb-4">
                        <x-form.input name="question"  type="text"  label=" السؤال" placeholder="ادخل السؤال" value="{{$question->question}}" />
                    </div>

                    <div class="col-12  mb-4">
                        <x-form.textarea name="answer"   label=" الإجابة " placeholder="ادخل الإجابة" value="{{$question->answer}}"/>
                    </div>


                    <div class="d-flex justify-content-center">
                        <button type="submit" class="submit-btn w-25"> تعديل السؤال</button>
                    </div>

                </form>

            </div>

        </div>

    </section>

</x-main-layout>
