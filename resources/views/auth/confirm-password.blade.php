<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Ito ay isang secure na bahagi ng sistema. Mangyaring kumpirmahin ang iyong password bago magpatuloy.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-6">
            <x-primary-button class="bg-blue-600 hover:bg-blue-700">
                {{ __('Kumpirmahin') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>