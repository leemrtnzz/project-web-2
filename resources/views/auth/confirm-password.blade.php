<x-guest-layout title="Konfirmasi Password — {{ config('app.name', 'KLIKIN') }}">
    <div class="mb-6">
        <h1 class="font-display text-2xl uppercase leading-none">Konfirmasi Password</h1>
        <p class="mt-2 text-sm font-medium text-ink/60">
            Ini area aman. Masukkan password kamu untuk melanjutkan.
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="mt-1 block w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <x-primary-button class="w-full">
            {{ __('Konfirmasi') }}
        </x-primary-button>
    </form>
</x-guest-layout>
