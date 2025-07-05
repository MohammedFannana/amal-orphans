<div class="row">
    <div class="col-12 col-md-6 mb-3">
        <x-form.input name="name" value="{{$researcher->name}}" type="text" id="name" label="اسم الباحث" placeholder="ادخل الاسم" />
    </div>

    <div class="col-12 col-md-6 mb-3">
        <x-form.input name="email" value="{{$researcher->email}}"  type="email" id="email" label="البريد الالكتروني" placeholder="ادخل البريد الالكتروني" />
    </div>

    <div class="col-12 col-md-6 mb-3">
        <x-form.input name="id_number" value="{{$researcher->id_number}}" type="text" id="id_number" label="رقم الهوية" placeholder="ادخل رقم الهوية" />
    </div>

    <div class="col-12 col-md-6 mb-3">
        <x-form.input name="phone" value="{{$researcher->phone}}" type="text" id="phone" label="رقم الهاتف " placeholder="ادخل رقم الهاتف" />
    </div>


    <div class="col-12 col-md-6 mb-3">
        <x-form.input name="phone_whats" value="{{$researcher->phone_whats}}" type="text" id="phone_whats" label="رقم الهاتف واتس" placeholder="ادخل رقم الهاتف واتس" />
    </div>

    <div class="col-md-6"></div>

    @if ($button == 'حفظ الباحث')

        <div class="col-12 col-md-6 mb-3">
            <x-form.input name="password"  type="password" id="password" label="كلمة المرور" placeholder="ادخل كلمة المرور" />
        </div>

        <div class="col-12 col-md-6 mb-3">
            <x-form.input name="password_confirmation"  type="password" id="password_confirmation" label="تأكيد كلمة المرور" placeholder="ادخل تأكيد كلمة المرور" />
        </div>

    @endif

</div>

<div class="d-flex justify-content-center gap-4 mt-4">
    <button class="submit-btn mb-4"  type="submit"> {{$button}} </button>
</div>
