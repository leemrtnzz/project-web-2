<x-guest-layout title="Lupa Password — {{ config('app.name', 'KLIKIN') }}">
    <div class="mb-6">
        <h1 class="font-display text-2xl uppercase leading-none">Lupa Password</h1>
        <p class="mt-2 text-sm font-medium text-ink/60">
            Masukkan email kamu, kami akan kirim tautan untuk membuat password baru.
        </p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <x-primary-button class="w-full">
            {{ __('Kirim Tautan Reset') }}
        </x-primary-button>

        <p class="text-center text-sm font-medium text-ink/60">
            <a class="nb-link" href="{{ route('login') }}">Kembali ke halaman masuk</a>
        </p>
    </form>
</x-guest-layout>
