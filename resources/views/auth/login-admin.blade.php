<x-guest-layout>
    {{-- login --}}
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <p class="fw-bold d-flex justify-content-center gap-2 fs-5" style="color: var(--primary-color)">
        <img src="{{asset('images/hand.png')}}" alt="" width="24px" height="24px">
        ! أهلاً بك
    </p>

   
    <form method="POST" action="{{ route('login') }}" dir="rtl">
        @csrf

        {{--  --}}
        <input type="hidden" name="guard" id="web" value="web">

        <!-- Email Address -->
        <div class="email-input" id="emailInput">
            <x-input-label for="email" :value="__('البريد الالكتروني')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"  autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>



        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('كلمة المرور')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->

        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('تذكرني') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 text-decoration-none" href="{{ route('password.request') }}" style="color:var(--primary-color);">
                        هل نسيت كلمة المرور؟
                    </a>
                @endif

                {{-- <x-primary-button class="ms-3">
                    {{ __('Log in') }}
                </x-primary-button> --}}
            </div>
        </div>

        <button type="submit" class="submit-btn w-100 text-center"> تسجيل الدخول </button>



    </form>

</x-guest-layout>
