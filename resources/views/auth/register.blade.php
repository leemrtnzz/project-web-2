<x-guest-layout title="Daftar — {{ config('app.name', 'KLIKIN') }}">
    <div class="mb-6">
        <h1 class="font-display text-2xl uppercase leading-none">Buat Akun</h1>
        <p class="mt-2 text-sm font-medium text-ink/60">Mulai kumpulkan semua link affiliate kamu dalam satu halaman.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Nama')" />
            <x-text-input id="name" class="mt-1 block w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="username" :value="__('Username')" />
            <div class="flex items-stretch">
                <span class="grid shrink-0 place-items-center border-4 border-r-0 border-ink bg-pop-yellow px-3 text-sm font-bold">
                    /u/
                </span>
                <x-text-input id="username" class="mt-0 block w-full" type="text" name="username" :value="old('username')" placeholder="namakamu" required autocomplete="username" maxlength="30" />
            </div>
            <p class="mt-1 text-xs font-medium text-ink/50">Huruf kecil, angka, tanda hubung, atau garis bawah.</p>
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="mt-1 block w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
            <x-text-input id="password_confirmation" class="mt-1 block w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full">
                {{ __('Daftar') }}
            </x-primary-button>
        </div>

        <p class="text-center text-sm font-medium text-ink/60">
            Sudah punya akun?
            <a class="nb-link" href="{{ route('login') }}">Masuk</a>
        </p>
    </form>
</x-guest-layout>
