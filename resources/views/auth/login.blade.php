<x-guest-layout>
    <!-- <div class="bg-white shadow-md rounded-lg p-8 max-w-md w-full mx-auto mt-12"> -->
        <div class="flex justify-center mb-6">
            <img src="{{ asset('images/logo-itats-new-BstgkVJz.webp') }}" alt="ITATS Logo" class="h-20">
        </div>

        <h2 class="text-2xl font-lilita-one-regular  text-center text-gray-800" >TRACER ALUMNI</h2>
        <p class="text-sm text-center text-gray-500 mb-6">Selamat Datang!</p>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- NPM -->
            <div>
                <x-input-label for="email" :value="__('NPM')" />
                <x-text-input id="email" class="block mt-1 w-full bg-blue-50"
                              type="text"
                              name="email"
                              :value="old('email')"
                              required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full bg-blue-50"
                              type="password"
                              name="password"
                              required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Login Button -->
            <div class="mt-6">
                <x-primary-button class="w-full justify-center">
                    {{ __('Masuk') }}
                </x-primary-button>
            </div>

            <!-- Register Link -->
            <div class="mt-4 text-center">
                <span class="text-sm text-gray-600">Belum punya akun?</span>
                <a href="{{ route('register') }}" class="text-sm font-semibold text-black hover:underline">
                    Buat Akun
                </a>
            </div>
        </form>
    <!-- </div> -->
</x-guest-layout>
