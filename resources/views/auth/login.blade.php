<x-guest-layout title="Masuk — {{ config('app.name', 'KLIKIN') }}">
    <div class="mb-6">
        <h1 class="font-display text-2xl uppercase leading-none">Masuk</h1>
        <p class="mt-2 text-sm font-medium text-ink/60">Lanjut kelola halaman affiliate kamu.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="mt-1 block w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between gap-3">
            <label for="remember_me" class="inline-flex items-center gap-2">
                <input id="remember_me" type="checkbox" class="h-5 w-5 border-4 border-ink text-ink focus:ring-0" name="remember">
                <span class="text-sm font-bold">{{ __('Ingat saya') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-xs font-bold underline decoration-2 underline-offset-4 hover:bg-pop-yellow" href="{{ route('password.request') }}">
                    {{ __('Lupa password?') }}
                </a>
            @endif
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full">
                {{ __('Masuk') }}
            </x-primary-button>
        </div>

        <p class="text-center text-sm font-medium text-ink/60">
            Belum punya akun?
            <a class="nb-link" href="{{ route('register') }}">Daftar</a>
        </p>
    </form>
</x-guest-layout>
