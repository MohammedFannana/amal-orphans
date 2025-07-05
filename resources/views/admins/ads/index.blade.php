<x-main-layout title="1000 أمل لأبناء الشهداء">

    @push('styles')



    @endpush

    <x-alert name="success" />
    <x-alert name="danger" />


    <div class="header fw-bold" style="color: var(--primary-color);font-size:18px;  border-top-right-radius: 6px;border-top-left-radius:6px; padding:10px;background:linear-gradient(to left , #c6fdda , #edfaf1)">
        مرحبًا بك في لوحة الأدمن
        <p class="fw-normal mt-2" style="font-size: 15px; color:var(--text-color)" >
            يعرض هذا القسم الاعلانات المسجلة  مع إمكانية حذفها اضافتها  .
        </p>
    </div>

    <section class="ads-information mt-5">

        {{--    --}}


        <div class="rounded">

            <div class="mt-5">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                    <p class="fs-5 fw-semibold custom-sm-style mb-1" style="color: var(--primary-color)"> قائمة الإعلانات في النظام </p>

                    <a href="{{route('admin.ad.create')}}" class="submit-btn text-decoration-none ">+ إضافة إعلان </a>
                </div>

            </div>

            <div class="table-responsive">
                <table  class=" border-0 w-100 text-center" style="border-collapse: collapse;">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الإعلان</th>
                            <th> الاجراءات </th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($ads as $ad)

                            <tr>
                                <td><span class="value">  {{$ad->id}}                 </span></td>
                                <td>
                                    <img src="{{ asset('storage/' . $ad->ad) }}" alt="" width="60px">
                                </td>

                                <td style="position: relative;">

                                    <img class="show-action" src="{{asset('images/Group 8.svg')}}" alt="">

                                    <div class="action" >

                                        <button  class="submit border-0 p-0 bg-transparent d-flex btn-delete" style="gap:7px">
                                            <img src="{{asset('images/Delete.svg')}}" alt="">
                                            <span style="color: var(--text-color);">{{__(' حذف الإعلان ')}}</span>
                                        </button>

                                        <form  action="{{route('admin.ad.destroy' , $ad->id)}}" method="post" style="display: none">
                                            @csrf
                                            @method('delete')

                                        </form>
                                    </div>

                                </td>
                            </tr>

                        @empty

                             <tr>
                                <td colspan="6" class="text-center fs-5 rounded" style="color:var(--primary-color)">
                                    {{__('لا يوجد إهلانات مسجلة في النظام')}}
                                </td>
                            </tr>

                        @endforelse


                    </tbody>
                </table>
            </div>



        </div>

    </section>

    {{$ads->withQueryString()->links()}}


</x-main-layout>
