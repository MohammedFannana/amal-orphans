<x-main-layout title="1000 أمل لأبناء الشهداء">


    <div class="header fw-bold" style="color: var(--primary-color);font-size:18px;  border-top-right-radius: 6px;border-top-left-radius:6px; padding:10px;background:linear-gradient(to left , #c6fdda , #edfaf1)">
        مرحبًا بك في لوحة الأدمن
        <p class="fw-normal mt-2" style="font-size: 15px;color:var(--text-color)">
            يعرض هذا القسم الأشئلة الشائعة المسجلة في النظام، حيث يمكنك الاطلاع على الاسئلة و مراجعة الاجابات وتحديثها عند الحاجة.  .
        </p>
    </div>

    <x-alert name="success" class="mt-2"/>
    <x-alert name="danger" class="mt-2"/>

    <section class="family-information mt-5">

        <div class="rounded">

            <div class="mt-4">
                <div class="d-flex justify-content-between mb-3">
                    <p class="fs-5 fw-semibold"> قائمة الأسئلةالشائعة  </p>
                    <a href="{{route('admin.question.create')}}" class="submit-btn text-decoration-none">+ إضافة سؤال </a>
                </div>
            </div>


            <div class="row">
                @forelse ($questions as $question)
                    <div class="card col-12 p-2">
                        <h6> {{$question->question}} </h6>
                        <p>
                            {{$question->answer}}
                        </p>

                        <div class="d-flex gap-4">
                            <a href="{{route('admin.question.edit' , $question->id)}}" class="submit-btn text-decoration-none" > تعديل </a>

                            <button  class="btn submit text-white bg-danger btn-delete" style="border-radius: 15px">
                                <span>{{__('حذف ')}}</span>
                            </button>

                            <form  action="{{route('admin.question.destroy' , $question->id)}}" method="post" style="display: none">
                                @csrf
                                @method('delete')

                            </form>

                        </div>
                    </div>

                @empty

                  <div class="p-3 fs-6 fw-semibold  rounded w-100" style="background:linear-gradient(to left , #c6fdda , #edfaf1)">
                      عذرًا، لا توجد أي أسئلة شائعة
                  </div>

                @endforelse

            </div>


        </div>

    </section>

    {{$questions->withQueryString()->links()}}

</x-main-layout>
