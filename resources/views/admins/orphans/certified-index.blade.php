<x-main-layout title="1000 أمل لأبناء الشهداء">

    @push('styles')
        <style>
            .orphan-intro {
                display: flex;

            }

            @media (max-width: 576px) { /* XS وأصغر */
                .orphan-intro {
                    flex-wrap: wrap;
                    width:100%;
                }
                .buttons{
                    flex-wrap: wrap;
                }
                .width-button{
                        width:100%;
                }
            }
        </style>
    @endpush

    <div class="header fw-bold" style="color: var(--primary-color); font-size:18px; border-top-right-radius:6px; border-top-left-radius:6px; padding:10px; background:linear-gradient(to left , #c6fdda , #edfaf1)">
        مرحبًا بك في لوحة الأدمن
        <p class="fw-normal mt-2" style="font-size: 15px;color:var(--text-color)">
            يعرض هذا القسم الأيتام المسجلين في النظام، حيث يمكنك الاطلاع على ملفاتهم الشخصية، مراجعة بياناتهم، وتحديثها عند الحاجة. مما يسهل عملية الإشراف والإدارة بشكل شامل ومنظم.
        </p>
    </div>

    <x-alert name="success" class="mt-2"/>
    <x-alert name="danger" class="mt-2"/>

    <section class="family-information mt-5">
        <div class="rounded">

            <div class="mt-4">
                <div class="orphan-intro justify-content-between mb-3">
                    <p class="fs-5 fw-semibold">قائمة الأيتام المعتمدين  </p>
                    <a href="{{ route('admin.orphan.create') }}" class="submit-btn text-decoration-none  text-center">+ إضافة يتيم</a>
                </div>

                <div class="orphan-intro2 justify-content-between flex-wrap align-items-center mb-2" style="display: none">
                    <div><p class="fs-5 checkbox-count mt-2">عنصر</p></div>
                    <div class="d-flex gap-2 align-items-start buttons">
                        <a href="{{ route('admin.orphan.generate.waiting') }}" type="button" id="submit_orphan_ids" class="submit-btn text-decoration-none width-button text-center" style="border-radius: 5px">ترشيح للكفالة</a>
                        <button id="reset_button" class="btn btn-danger width-button" style="padding: 9px 24px">إلغاء</button>
                    </div>
                </div>

                <form action="{{ route('admin.orphan.CertifiedOrphan') }}" method="GET" class="search custom-sm-style w-100">
                    @csrf
                    <div class="input-group flex-nowrap mb-4">
                        <input type="text" name="search" class="form-control" placeholder="البحث عن يتيم..." aria-describedby="addon-wrapping">
                        <button type="submit" class="input-group-text" id="addon-wrapping">
                            <svg xmlns="http://www.w3.org/2000/svg" height="18" width="18" viewBox="0 0 512 512">
                                <path fill="#1e9448" d="M384 208A176 176 0 1 0 32 208a176 176 0 1 0 352 0zM343.3 366C307 397.2 259.7 416 208 416C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208c0 51.7-18.8 99-50 135.3L507.3 484.7c6.2 6.2 6.2 16.4 0 22.6s-16.4 6.2-22.6 0L343.3 366z"/>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="border-0 w-100 text-center" style="border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th></th>
                            <th>#</th>
                            <th>اسم اليتيم</th>
                            <th>الجنس</th>
                            <th>حالة اليتيم</th>
                            <th>اسم الجمعية</th>
                            <th>الدولة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orphans as $orphan)
                            <tr>
                                <td>
                                    <input type="checkbox" name="orphan_ids[]" value="{{ $orphan->id }}" class="select_orphan_checkbox" id="orphan_{{ $orphan->id }}">
                                </td>
                                <td><span class="value">{{ $orphan->id }}</span></td>
                                <td><span class="value">{{ $orphan->name }}</span></td>
                                <td><span class="value">{{ $orphan->gender }}</span></td>
                                <td><span class="value">{{ $orphan->orphan_status }}</span></td>
                                <td><span class="value">{{ $orphan->association->name }}</span></td>
                                <td><span class="value">{{ $orphan->country }}</span></td>
                                <td style="position: relative;">
                                    <img class="show-action" src="{{ asset('images/Group 8.svg') }}" alt="">
                                    <div class="action">
                                        <a href="{{ route('admin.orphan.show', $orphan->id) }}" class="text-decoration-none mb-1">
                                            <img src="{{ asset('images/Show.svg') }}" alt="">
                                            <span style="color: var(--text-color);">عرض التفاصيل</span>
                                        </a>
                                        <a href="{{ route('admin.orphan.edit', $orphan->id) }}" class="text-decoration-none mb-1">
                                            <img src="{{ asset('images/Edit Square.svg') }}" alt="">
                                            <span style="color: var(--text-color);">تعديل البيانات</span>
                                        </a>
                                        <button class="submit border-0 p-0 bg-transparent d-flex btn-delete" style="gap:7px">
                                            <img src="{{ asset('images/Delete.svg') }}" alt="">
                                            <span style="color: var(--text-color);">حذف اليتيم</span>
                                        </button>
                                        <form action="{{ route('admin.orphan.destroy', $orphan->id) }}" method="post" style="display: none">
                                            @csrf
                                            @method('delete')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center fs-5" style="color:var(--primary-color)">
                                    لا يوجد أيتام مكفولين مسجلين في النظام
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    {{ $orphans->withQueryString()->links() }}

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function () {
                $('.select_orphan_checkbox').change(function () {
                    let selectedCount = $('.select_orphan_checkbox:checked').length;

                    if (selectedCount > 0) {
                        $('.orphan-intro').hide();
                        $('.orphan-intro2').show().addClass('d-flex');
                        $('.orphan-intro2 .checkbox-count').text(selectedCount + ' حالة');
                    } else {
                        $('.orphan-intro').show();
                        $('.orphan-intro2').hide().removeClass('d-flex');

                    }
                });

                $('#reset_button').click(function (e) {
                    e.preventDefault();
                    $('.select_orphan_checkbox').prop('checked', false);
                    $('.orphan-intro').show();
                    $('.orphan-intro2').hide().removeClass('d-flex');
                });

                $('#submit_orphan_ids').click(function (event) {
                    event.preventDefault();

                    let selected = document.querySelectorAll('.select_orphan_checkbox:checked');
                    if (selected.length === 0) {
                        alert("يرجى اختيار يتيم واحد على الأقل.");
                        return;
                    }

                    let ids = Array.from(selected).map(cb => cb.value).join(',');
                    window.location.href = `{{ route('admin.orphan.generate.waiting') }}?orphan_ids=${ids}`;
                });
            });
        </script>
    @endpush

</x-main-layout>
