<x-main-layout>


    <x-alert name="success" />
    <x-alert name="danger" />



    <div class="d-flex justify-content-center mt-5">

        <video width="280" height="280" controls autoplay>
            <source src="{{ asset('storage/' . $filePath) }}" >
            المتصفح لا يدعم تشغيل الفيديو.
        </video>

    </div>


</x-main-layout>
