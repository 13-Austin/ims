<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Salamat sa pag-sign up! Bago magsimula, maaari mo bang i-verify ang iyong email address sa pamamagitan ng pag-click sa link na ipinadala namin sa iyo? Kung hindi mo natanggap ang email, ikalulugod naming padalhan ka muli.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('Isang bagong verification link ang ipinadala sa email address na ibinigay mo noong nagrehistro ka.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <div>
                <x-primary-button class="bg-blue-600 hover:bg-blue-700">
                    {{ __('Ipadala Muli ang Verification Email') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                {{ __('Mag-log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>