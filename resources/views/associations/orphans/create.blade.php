<x-main-layout title="1000 أمل لأبناء الشهداء">

    <section class="mt-1">

        <x-alert name="success" />
        <x-alert name="danger" />



        {{-- section header component --}}
        <x-header1 title=" إضافة يتيم " description=" في هذا القسم يمكنك إضافة يتيم جديد إلى النظام من خلال تعبئة البيانات الأساسية . يرجى التأكد من صحة البيانات قبل الحفظ. "/>

        <div class="rounded mt-3" style="border-top-color:#f0fff4 !important">

            <div class="mt-4 mb-4 row">


                <form action="{{route('orphan.store')}}" method="post" enctype="multipart/form-data">
                    @csrf

                    @include('associations.orphans._form' , [
                            'button' => __('حفظ بيانات اليتيم')])

                </form>

            </div>

        </div>

    </section>

    @push('scripts')

        <script>
            function addRow() {
                const table = document.getElementById("siblingsTable").getElementsByTagName('tbody')[0];
                const rowCount = table.rows.length + 1;
                const row = table.insertRow();
                row.innerHTML = `
                    <td>${rowCount}</td>
                    <td>
                        <input name="brother_name[]" type="text" placeholder="أدخل اسم الأخ/الأخت" class="rounded form-control" />
                    </td>
                    <td>
                        <select name="brother_gender[]" class="form-control rounded form-select">
                            <option value="ذكر">ذكر</option>
                            <option value="أنثى">أنثى</option>
                        </select>
                    </td>
                    <td>
                        <input name="brother_age[]" type="text" placeholder="أدخل العمر" class="rounded form-control" />
                    </td>
                    <td>
                       <select name="brother_marital_status[]" class="form-control rounded form-select">
                            <option value="أعزب">أعزب</option>
                            <option value="متزوج">متزوج</option>
                            <option value="أرمل">أرمل</option>
                            <option value="مطلق">مطلق</option>
                            <option value="مهجورة">مهجورة</option>
                        </select>
                    </td>
                    <td>
                        <input name="brother_jop[]" type="text" placeholder="المهنة" class="rounded form-control" />
                    </td>
                    <td>
                        <input name="brother_id_number[]" type="text" placeholder="رقم الهوية" class="rounded form-control" />
                    </td>
                `;
            }
        </script>

        <script>

            document.addEventListener('DOMContentLoaded', function () {
                const radios = document.querySelectorAll('input[name="orphan_status"]');

                const parentDeathDiv = document.getElementById('parent_death');
                const motherDeathDiv = document.getElementById('mother_death');
                const fatherDeathDiv = document.getElementById('father_death');

                // إزالة name من الحقول داخل عنصر
                function disableFields(container) {
                    const inputs = container.querySelectorAll('[name]');
                    inputs.forEach(input => {
                        input.dataset.name = input.name; // حفظ الاسم في data-name
                        input.removeAttribute('name');   // إزالة الاسم
                    });
                }

                // إعادة name إلى الحقول من data-name
                function enableFields(container) {
                    const inputs = container.querySelectorAll('[data-name]');
                    inputs.forEach(input => {
                        input.setAttribute('name', input.dataset.name);
                    });
                }

                function updateSections() {
                    const selected = document.querySelector('input[name="orphan_status"]:checked');
                    if (!selected) return;

                    // إخفاء الكل + إزالة أسماء الحقول
                    [parentDeathDiv, motherDeathDiv, fatherDeathDiv].forEach(div => {
                        div.style.display = 'none';
                        disableFields(div);
                    });

                    // إظهار القسم المطلوب + إعادة أسماء الحقول
                    switch (selected.value.trim()) {
                        case 'يتيم الأبوين':
                            parentDeathDiv.style.display = 'block';
                            enableFields(parentDeathDiv);
                            break;
                        case 'يتيم الأم':
                            motherDeathDiv.style.display = 'block';
                            enableFields(motherDeathDiv);
                            break;
                        case 'يتيم الأب':
                            fatherDeathDiv.style.display = 'block';
                            enableFields(fatherDeathDiv);
                            break;
                    }
                }

                radios.forEach(radio => {
                    radio.addEventListener('change', updateSections);
                });

                updateSections(); // عند التحميل الأولي
            });


        </script>

        {{-- script for bank and wallet --}}
        <script>
            function toggleReceiveDivs() {
                const bankDiv = document.getElementById('receive-bank');
                const walletDiv = document.getElementById('receive-wallet');

                const selected = document.querySelector('input[name="receive_guarantee"]:checked')?.value;

                if (selected === 'bank') {
                    bankDiv.style.display = 'block';
                    walletDiv.style.display = 'none';
                } else if (selected === 'wallet') {
                    bankDiv.style.display = 'none';
                    walletDiv.style.display = 'block';
                } else {
                    bankDiv.style.display = 'none';
                    walletDiv.style.display = 'none';
                }
            }
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const fixedIncome = document.getElementById("fixed_income");
                const noIncome = document.getElementById("no_income");
                const incomeFields = document.querySelectorAll(".income");

                // دالة لإظهار أو إخفاء الحقول
                function toggleIncomeFields(show) {
                    incomeFields.forEach(el => {
                        el.style.display = show ? "block" : "none";
                    });
                }

                // عند تغيير الاختيار
                fixedIncome.addEventListener("change", () => {
                    if (fixedIncome.checked) toggleIncomeFields(true);
                });

                noIncome.addEventListener("change", () => {
                    if (noIncome.checked) toggleIncomeFields(false);
                });

                // عند تحميل الصفحة — في حالة التعديل أو إعادة تحميل
                if (fixedIncome.checked) {
                    toggleIncomeFields(true);
                } else {
                    toggleIncomeFields(false);
                }
            });
        </script>

    @endpush

</x-main-layout>
