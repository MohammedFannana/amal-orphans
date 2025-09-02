<x-main-layout title="1000 أمل لأبناء الشهداء">

    @push('styles')

        <style>
            .color-text{
                color:rgba(36, 36, 36, 0.6);
            }

        </style>

    @endpush


    <div class="header fw-bold" style="color: var(--primary-color);font-size:18px;  border-top-right-radius: 6px;border-top-left-radius:6px; padding:10px;background:linear-gradient(to left , #c6fdda , #edfaf1)">
        مرحبًا بك في لوحة الأدمن
        <p class="color-text fw-normal mt-2" style="font-size: 15px">
            يعرض هذا القسم تقارير الأيتام المسجلين في النظام، حيث يمكنك الاطلاع على تقاريرهم مراجعة بياناتهم .  مما يسهل عملية الإشراف والإدارة بشكل شامل ومنظم.
        </p>
    </div>

    <x-alert name="success" class="mt-2"/>
    <x-alert name="danger" class="mt-2"/>



    <section class="family-information mt-5">

        <div class="rounded">

            <div class="mt-4">

                <div class="d-flex justify-content-between mb-3">
                    <p class="fs-5 fw-semibold"> قائمة تقارير الأيتام </p>
                    <!-- Dropdown Button -->
                    <div class="dropdown">
                        <button class="submit-btn dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            تصدير تقرير
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#exportModal" data-route="{{ route('admin.report.excel') }}"> تصدير Excel </a></li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#exportModal" data-route="{{ route('admin.report.pdf') }}"> تصدير Pdf </a></li>
                        </ul>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form id="exportForm" method="POST" action="">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exportModalLabel">تصدير التقرير</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="reportDate" class="form-label">اختر تاريخ التقرير</label>

                                        <div class="d-flex gap-2">
                                            <div style="width:48%">
                                                <label for="">من</label>
                                                <input type="month" class="form-control" name="date" id="reportDate"  required>
                                            </div>

                                            <div style="width:48%">
                                                <label for="">إلى</label>
                                                <input type="month" class="form-control" name="date_to" id="reportDateTo" label="إلى" required>
                                            </div>
                                        </div>


                                        <input type="hidden" class="form-control" name="type" value="orphan" id="type">

                                    </div>
                                </div>

                                <div id="conditions-container" class="ps-3">
                                    <div class="d-flex align-items-center align-items-center flex-wrap gap-3 mb-2 condition-row">

                                        <div>
                                            <x-form.select label="ابحث حسب" name="search_by[]"
                                                :options="[
                                                    'role' => __('حالة اليتيم'),
                                                    'name' => __('اسم اليتيم'),
                                                    'id_number' => __('رقم هوية اليتيم'),
                                                    'association_id' => __(' اسم الجمعية '),
                                                    'birth_date' => __('تاريخ ميلاد اليتيم'),
                                                    'country' => __('الدولة'),
                                                    'city' => __('المدينة'),
                                                    'orphan_status' => __('حالة اليتيم'),
                                                    'gender' => __('جنس اليتيم'),
                                                    'income' => __(' مصدر الدخل '),
                                                    // 'health_status' => __('الحالة الصحية'),
                                                    // 'educational_status	' => __('الحالة التعليمية'),
                                                ]"
                                                value="name"
                                                class="search-by"
                                            />
                                        </div>

                                        <div>
                                            <x-form.select label="الشرط" name="condition[]"
                                                :options="['==' => __('مطابق ل')]"
                                            />
                                        </div>

                                        <div style="width:40%">
                                            <label class="mb-2 fw-bold">القيمة</label>
                                            <div class="search-input-wrapper">
                                                <select name="search_value[]" class="form-select search-options"></select>
                                            </div>
                                        </div>

                                        <button type="button" id="add-condition" class="btn" style="border: 1px solid var(--primary-color); color: var(--primary-color);margin-top:1.9rem">
                                            + شرط جديد
                                        </button>

                                    </div>
                                </div>

                                <div class="modal-footer">
                                    {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button> --}}
                                    <span class="fs-5 me-4" id="loadingText" style="display:none; color:#0d6efd; font-weight:bold;">
                                        جاري التحميل...
                                    </span>
                                    <button type="submit" class="submit-btn">تصدير</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                @if ($reports->isNotEmpty())
                    <form action="{{route('admin.report.sponsor')}}" method="GET" class="search custom-sm-style w-100">

                        @csrf
                        <div class="input-group flex-nowrap mb-4">

                            <input type="month" name="search" class="form-control" placeholder="{{__('البحث عن تقرير...')}}"  aria-describedby="addon-wrapping">
                            <button type="submit" class="input-group-text" id="addon-wrapping" >
                                <svg xmlns="http://www.w3.org/2000/svg" height="18" width="18" viewBox="0 0 512 512"><path fill="#1e9448" d="M384 208A176 176 0 1 0 32 208a176 176 0 1 0 352 0zM343.3 366C307 397.2 259.7 416 208 416C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208c0 51.7-18.8 99-50 135.3L507.3 484.7c6.2 6.2 6.2 16.4 0 22.6s-16.4 6.2-22.6 0L343.3 366z"/></svg>
                            </button>
                        </div>

                    </form>
                @endif

            </div>


            <div class="row">

                @forelse ($reports as $report)

                    <div class="col-12 col-md-6 col-lg-4 d-flex mb-2">

                        <div class="d-flex justify-content-between align-items-center p-3 rounded shadow-sm" style="background-color:#c6fdda;">

                            <div class="d-flex align-items-center gap-3">
                                <div class="p-2 rounded bg-white shadow-sm">
                                    <img src="{{ asset('images/order.png') }}" alt="report" width="40" height="50">
                                </div>

                                <div>
                                    <h6 class="fw-bold mb-1" style="color: var(--primary-color)">
                                        تقرير الأيتام
                                        <span class="fs-6">
                                            ({{ pathinfo($report->report, PATHINFO_EXTENSION) }})
                                        </span>
                                    </h6>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($report->date)->format('m-Y') }} - {{ \Carbon\Carbon::parse($report->date_to)->format('m-Y') }}</small>
                                </div>
                            </div>

                            <div class="d-flex flex-column gap-1">
                                <a href="{{ route('admin.report.download', $report->id) }}"
                                    class="btn btn-sm  text-white"style="background-color: var(--primary-color);">تنزيل
                                </a>

                                <form action="{{ route('admin.report.destroy', $report->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                                </form>
                            </div>

                        </div>

                    </div>

                @empty

                    <div class="col-12 text-white text-center rounded p-2" style="background-color: var(--primary-color)"> لا يوجد تقارير للكفلاء لعرضها </div>

                @endforelse

            </div>



        </div>

    </section>

    @push('scripts')

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var exportModal = document.getElementById('exportModal');
            exportModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var route = button.getAttribute('data-route');
                // var route = button.dataset.route;

                document.getElementById('exportForm').action = route;
            });
        });

    </script>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const container = document.getElementById("conditions-container");
            const addBtn = document.getElementById("add-condition");

            const optionsData = {
                // health_status: [
                //     { value: "جيد", text: "جيد" },
                //     { value: "مريض", text: "مريض" },
                // ],
                gender: [
                    { value: "ذكر", text: "ذكر" },
                    { value: "أنثى", text: "أنثى" },
                ],
                // educational_status: [
                //     { value: "دون سن الدراسة", text: "دون سن الدراسة" },
                //     { value: "يدرس", text: "يدرس" },
                //     { value: "لا يدرس", text: "لا يدرس" },
                // ],
                orphan_status: [
                    { value: "يتيم الأم", text: "يتيم الأم" },
                    { value: "يتيم الأب", text: "يتيم الأب" },
                    { value: "يتيم الأبوين", text: "يتيم الأبوين" },
                ],
                income: [
                    { value: "بدون دخل", text: "بدون دخل" },
                    { value: "دخل ثابت", text: "دخل ثابت" },
                ],
                role: [
                    { value: "candidate", text: "الأيتام المرشحين" },
                    { value: "auditor", text: "الأيتام المدققين" },
                    { value: "certified", text: "الأيتام المعتمدين" },
                    { value: "waiting", text: "الأيتام على قائمة الانتظار" },
                    { value: "sponsored", text: "الأيتام الكفولين" },
                ],
                association_id: @json(
                    $assoc->map(fn($item) => [
                        'value' => $item->id,
                        'text'  => $item->name
                    ])
                ),

            };


            function createInput(type, name) {
                const input = document.createElement("input");
                input.type = type;
                input.name = name;
                input.className = "form-control";
                return input;
            }

            function createSelect(options, name) {
                const select = document.createElement("select");
                select.name = name;
                select.className = "form-select";

                options.forEach(opt => {
                    const option = document.createElement("option");
                    option.value = opt.value;
                    option.textContent = opt.text;
                    select.appendChild(option);
                });

                return select;
            }

            function updateInputField(wrapper, key) {
                wrapper.innerHTML = "";

                // if (key === "orphan_sibling") {
                //     wrapper.appendChild(createInput("number", "search_value[]"));
                // } else

                if (key === "birth_date") {
                    wrapper.appendChild(createInput("date", "search_value[]"));
                } else if (optionsData[key]) {
                    wrapper.appendChild(createSelect(optionsData[key], "search_value[]"));
                } else {
                    wrapper.appendChild(createInput("text", "search_value[]"));
                }
            }

            // تحديث السطر الأول عند التحميل
            const firstSearchBy = container.querySelector(".search-by");
            const firstInputWrapper = container.querySelector(".search-input-wrapper");
            updateInputField(firstInputWrapper, firstSearchBy.value);
            firstSearchBy.addEventListener("change", function () {
                updateInputField(firstInputWrapper, this.value);
            });

            addBtn.addEventListener("click", function () {
                const row = document.createElement("div");
                row.className = "d-flex align-items-center flex-wrap gap-3 mb-2 condition-row";

                row.innerHTML = `
                    <div>
                        <select name="search_by[]" class="form-select search-by">
                            <option value="role"> حالة اليتيم </option>
                            <option value="name"> اسم اليتيم </option>
                            <option value="id_number"> رقم هوية اليتيم </option>
                            <option value="association_id"> اسم الجمعية </option>
                            <option value="birth_date"> تاريخ ميلاد اليتيم </option>
                            <option value="country"> الدولة </option>
                            <option value="country"> المدينة </option>
                            <option value="gender"> جنس اليتيم </option>
                            <option value="orphan_status"> (يتيم الأم,....)حالة اليتيم </option>
                            <option value="income"> مصدر الدخل  </option>

                        </select>
                    </div>

                    <div>
                        <select name="condition[]" class="form-select">
                            <option value="==">مطابق ل</option>
                        </select>
                    </div>

                    <div style="width:45%">
                        <div class="search-input-wrapper"></div>
                    </div>

                    <button type="button" class="btn btn-danger remove-condition">
                        <img src="{{asset('assets/icon/delete.png')}}" alt="">
                        <span> حذف </span>
                    </button>
                `;

                container.appendChild(row);

                const select = row.querySelector(".search-by");
                const wrapper = row.querySelector(".search-input-wrapper");
                updateInputField(wrapper, select.value);

                select.addEventListener("change", function () {
                    updateInputField(wrapper, this.value);
                });

                row.querySelector(".remove-condition").addEventListener("click", function () {
                    row.remove();
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const exportForm = document.getElementById('exportForm');
            const loadingText = document.getElementById('loadingText');
            const submitBtn = document.querySelector('.submit-btn');

            exportForm.addEventListener('submit', function () {
                loadingText.style.display = 'inline-block'; // أظهر النص
                submitBtn.disabled = true; // عطل الزر
                submitBtn.textContent = 'جاري التصدير...'; // غير النص
            });
        });
    </script>



    @endpush

    {{$reports->withQueryString()->links()}}

</x-main-layout>
