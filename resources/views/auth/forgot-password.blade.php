<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Nakalimutan ang password? Walang problema. Ibigay lamang sa amin ang iyong email address at padadalhan ka namin ng link para makapili ka ng bagong password.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <x-primary-button class="bg-blue-600 hover:bg-blue-700">
                {{ __('Ipadala ang Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>