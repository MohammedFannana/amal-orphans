<div class="row ms-5 me-5">
    <div class="col-12  mb-4">
        <x-form.input name="name" value="{{$association->name}}"  type="text" id="name" label="اسم الجمعية" placeholder="ادخل اسم الجمعية" />
    </div>

    <div class="col-12  mb-4">
        <x-form.input name="address" value="{{$association->address}}" type="text" id="address" label="العنوان " placeholder="ادخل العنوان" />
    </div>

    <div class="col-12  mb-4">
        <x-form.input name="responsible_person"  value="{{$association->responsible_person}}"  type="text" id="responsible_person" label="اسم الشخص المسؤول" placeholder="ادخل اسم الشخص المسؤول" />
    </div>

    <div class="col-12  mb-4">
        <x-form.input name="email" value="{{$association->email}}"  type="email" id="email" label="البريد الالكتروني" placeholder="ادخل البريد الالكتروني" />
    </div>

    <div class="col-12  mb-4">
        <x-form.input name="fax"  value="{{$association->fax}}" type="text" id="fax" label=" الفاكس " placeholder="ادخل الفاكس" />
    </div>

    <div class="col-12  mb-4">
        <x-form.input name="license_number"  value="{{$association->license_number}}" type="text" id="license_number" label="رقم الترخيص" placeholder="ادخل رقم الترخيص" />
    </div>

    <div class="col-12  mb-4">
        <x-form.input name="phone" value="{{$association->phone}}"  type="text" id="phone" label="رقم الهاتف " placeholder="ادخل رقم الهاتف" />
    </div>


    <div class="col-12  mb-4">
        <x-form.input name="phone1" value="{{$association->phone1}}"  type="text" id="phone1" label=" رقم الهاتف الأول" placeholder="ادخل رقم الهاتف" />
    </div>

    <div class="col-12  mb-4">
        <x-form.input name="phone2"  value="{{$association->phone2}}" type="text" id="phone2" label="رقم الهاتف الثاني" placeholder="ادخل رقم الهاتف" />
    </div>

    @if ($button == 'حفظ الجمعية')

        <div class="col-12 mb-4">
            <x-form.input name="password"  type="password" id="password" label="كلمة المرور" placeholder="ادخل كلمة المرور" />
        </div>

        <div class="col-12  mb-4">
            <x-form.input name="password_confirmation"  type="password" id="password_confirmation" label="تأكيد كلمة المرور" placeholder="ادخل تأكيد كلمة المرور" />
        </div>

    @endif

    <div class="d-flex justify-content-center gap-4 mt-4">
        <button class="submit-btn mb-4 w-100"  type="submit"> {{$button}} </button>
    </div>

</div>


