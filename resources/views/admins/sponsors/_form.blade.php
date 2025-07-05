<div class="row  ms-1 me-1">

    <div class="col-12 col-md-6   mb-4">
        <x-form.input name="name" value="{{$sponsor->name}}" type="text" id="name" label="اسم الكافل" placeholder="ادخل اسم الكافل" />
    </div>

    <div class="col-12 col-md-6  mb-4">
        <x-form.input name="phone" value="{{$sponsor->phone}}" type="text" id="phone" label="رقم الجوال" placeholder="ادخل رقم الجوال" />
    </div>

    <div class="col-12 col-md-6  mb-4">
        <x-form.input name="email"  value="{{$sponsor->email}}" type="email" id="email" label="البريد الالكتروني" placeholder="ادخل البريد الالكتروني" />
    </div>

    <div class="col-12 col-md-6   mb-4">
        <x-form.input name="country" value="{{$sponsor->country}}" type="text" id="country" label=" البلد " placeholder="ادخل بلد الكافل" />
    </div>


    <div class="col-12 col-md-6  mb-4">
        <x-form.input name="address" value="{{$sponsor->address}}"  type="text" id="address" label=" العنوان " placeholder="ادخل عنوان الكافل" />
    </div>

    @if ($button == 'حفظ البيانات')
        <div class="col-12 col-md-6   mb-4">
            <x-form.input name="password"  type="password" id="password" label="كلمة المرور" placeholder="ادخل كلمة المرور" />
        </div>

        <div class="col-12 col-md-6 mb-4">
            <x-form.input name="password_confirmation"  type="password" id="password_confirmation" label="تأكيد كلمة المرور" placeholder="ادخل تأكيد كلمة المرور" />
        </div>
    @endif

    <div class="col-12 col-md-6"></div>

    {{-- receive_report --}}
    <div class="col-6 col-md-6     mb-4">
        <label class="mb-2 fw-bold"> هل تود الحصول على تقارير دورية؟ </label>
        <div class="d-flex align-items-center gap-5">
            <div class="d-flex  gap-1">
                <input class="radio-input p-0" name="receive_report" type="radio" id="report_yes"  value="yes"
                 @checked($sponsor->receive_report == 'yes')/>
                <label class="form-check-label" for="report_yes" style="color: rgba(36, 36, 36, 0.6)">
                    نعم
                </label>
            </div>

            <div class="d-flex  gap-1">
                <input class="radio-input p-0" name="receive_report" type="radio" id="report_no"  value="no"
                   @checked($sponsor->receive_report == 'no')/>
                <label class="form-check-label" for="report_no" style="color: rgba(36, 36, 36, 0.6)">
                    لا
                </label>
            </div>

        </div>
        @error('receive_report')
            <div class="text-danger">
                {{$message}}
            </div>
        @enderror
    </div>

    {{-- payment_reminder --}}
    <div class="col-6 col-md-6  mb-4">
        <label class="mb-2 fw-bold"> هل تود التذكير بالدفع؟ </label>
        <div class="d-flex align-items-center gap-5">
            <div class="d-flex  gap-1">
                <input class="radio-input p-0" name="payment_reminder" type="radio" id="pay_yes"  value="yes"  @checked($sponsor->payment_reminder == 'yes')/>
                <label class="form-check-label" for="pay_yes" style="color: rgba(36, 36, 36, 0.6)">
                    نعم
                </label>
            </div>

            <div class="d-flex  gap-1">
                <input class="radio-input p-0" name="payment_reminder" type="radio" id="pay_no"  value="no"  @checked($sponsor->payment_reminder == 'no')/>
                <label class="form-check-label" for="pay_no" style="color: rgba(36, 36, 36, 0.6)">
                    لا
                </label>
            </div>

        </div>
        @error('payment_reminder')
            <div class="text-danger">
                {{$message}}
            </div>
        @enderror
    </div>


    {{-- payment_mechanism --}}
    <div class="col-12 mb-4">
        <label class="mb-2 fw-bold"> آلية الدفع </label>
        <div class="d-flex gap-1 flex-wrap align-items-center justify-content-between">
            <div class="d-flex  gap-1 border-1">
                <input class="radio-input p-0" name="payment_mechanism" type="radio" id="bank"  value="bank"  @checked($sponsor->payment_mechanism == 'bank')/>

                <label class="form-check-label mb-1" for="bank" style="color: rgba(36, 36, 36, 0.6)">
                    <img src="{{asset('images/bank.png')}}" alt="">
                    حساب البنك
                </label>
            </div>

            <div class="d-flex  gap-1">
                <input class="radio-input p-0" name="payment_mechanism" type="radio" id="credit_card"  value="credit_card"  @checked($sponsor->payment_mechanism == 'credit_card')/>
                <label class="form-check-label mb-1" for="credit_card" style="color: rgba(36, 36, 36, 0.6)">
                    <img src="{{asset('images/Icon.png')}}" alt="">
                    Credit Card
                </label>
            </div>

            <div class="d-flex gap-1">
                <input class="radio-input p-0" name="payment_mechanism"  type="radio" id="debit_card"  value="debit_card"  @checked($sponsor->payment_mechanism == 'debit_card')/>
                <label class="form-check-label mb-1" for="debit_card" style="color: rgba(36, 36, 36, 0.6)">
                    <img src="{{asset('images/Icon.png')}}" alt="">
                    Debit Card
                </label>
            </div>

            <div class="d-flex gap-1">
                <input class="radio-input p-0" name="payment_mechanism"  type="radio" id="PALPAY"  value="PALPAY"  @checked($sponsor->payment_mechanism == 'PALPAY')/>
                <label class="form-check-label mb-1" for="PALPAY" style="color: rgba(36, 36, 36, 0.6)">
                    <img src="{{asset('images/pal-pay.png')}}" alt="">
                    PALPAY
                </label>
            </div>

            <div class="d-flex gap-1">
                <input class="radio-input p-0" name="payment_mechanism"  type="radio" id="benefit_pay"  value="benefit_pay"  @checked($sponsor->payment_mechanism == 'benefit_pay')/>
                <label class="form-check-label mb-1" for="benefit_pay" style="color: rgba(36, 36, 36, 0.6)">
                    <img src="{{asset('images/benfit.png')}}" alt="">
                    Benefit Pay
                </label>
            </div>

        </div>
        @error('payment_mechanism')
            <div class="text-danger">
                {{$message}}
            </div>
        @enderror
    </div>



    <div class="d-flex justify-content-center gap-4 mt-4">
        <button class="submit-btn mb-4"  type="submit"> {{$button}} </button>
    </div>

</div>

