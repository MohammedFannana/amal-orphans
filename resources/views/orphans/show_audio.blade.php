<x-main-layout>


    <x-alert name="success" />
    <x-alert name="danger" />



    <div class="d-flex justify-content-center mt-5">

        <audio width="280" height="280" controls autoplay>
            <source src="{{ asset('storage/' . $filePath) }}" >
            المتصفح لا يدعم تشغيل الصوت.
        </audio>


    </div>


</x-main-layout>
