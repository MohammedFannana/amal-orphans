<x-main-layout title="1000 أمل لأبناء الشهداء">


    <div class="header fw-bold" style="color: var(--primary-color);font-size:18px;  border-top-right-radius: 6px;border-top-left-radius:6px; padding:10px;background:linear-gradient(to left , #c6fdda , #edfaf1)">
        مرحبًا بك في لوحة الجمعيات
        <p class="fw-normal mt-2" style="font-size: 15px;color:var(--text-color)">
            يعرض في هذا القسم الرسائل التي يرسها الأيتام الى الكافل
        </p>
    </div>

    <x-alert name="success" class="mt-2"/>
    <x-alert name="danger" class="mt-2"/>

    <section class="family-information mt-5">

        <div class="rounded">

            <div class="row gap-2">
                @forelse ($messages as $message)
                    {{-- @dd($message) --}}
                    <div class="card col-12 col-sm-6 col-md-4 col-lg-3 p-2">
                        {{-- @dd($message->orphan_id) --}}
                        <h5> {{$message->data['orphan_name']}} </h5>
                        <p>
                            {{$message->data['message']}}
                        </p>

                        <div class="d-flex row">
                            <form action="{{route('association.message.store' , $message->id)}}" method="post" class="col-7">
                                @csrf
                                <button type="submit" class="submit-btn"> قبول </button>
                            </form>

                            <button  class="btn submit text-white bg-danger btn-delete col-4" style="border-radius: 15px">
                                <span>{{__(' رفض ')}}</span>
                            </button>

                            <form  action="{{route('association.message.delete' , $message->id)}}" method="post" style="display: none">
                                @csrf
                                @method('delete')

                            </form>

                        </div>
                    </div>

                @empty

                  <div class="p-3 fs-6 fw-semibold  rounded w-100" style="background:linear-gradient(to left , #c6fdda , #edfaf1)">
                      عذرًا، لا توجد أي رسائل مرسلة من اليتيم إلى الكافل حتى الآن
                  </div>

                @endforelse

            </div>

        </div>

    </section>

    {{$messages->withQueryString()->links()}}

</x-main-layout>
