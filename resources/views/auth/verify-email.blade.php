<x-guest-layout title="Verifikasi Email — {{ config('app.name', 'KLIKIN') }}">
    <div class="mb-6">
        <h1 class="font-display text-2xl uppercase leading-none">Verifikasi Email</h1>
        <p class="mt-2 text-sm font-medium text-ink/60">
            Terima kasih sudah mendaftar! Klik tautan yang kami kirim ke email kamu untuk mengaktifkan akun.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 border-2 border-ink bg-pop-lime px-3 py-2 text-sm font-bold">
            {{ __('Tautan verifikasi baru telah dikirim ke email kamu.') }}
        </div>
    @endif

    <div class="flex flex-col gap-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <x-primary-button class="w-full">
                {{ __('Kirim Ulang Email Verifikasi') }}
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="nb-btn nb-btn-ghost w-full">
                {{ __('Keluar') }}
            </button>
        </form>
    </div>
</x-guest-layout>
