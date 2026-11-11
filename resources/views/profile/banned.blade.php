<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>AKUN DITANGGUHKAN — {{ $user->name }} ({{ '@'.$user->username }}) — {{ config('app.name', 'KLIKIN') }}</title>
        <meta name="robots" content="noindex, nofollow">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=archivo-black:400|space-grotesk:400,500,600,700" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            .hazard-tape {
                background: repeating-linear-gradient(
                    -45deg,
                    #FFD43B,
                    #FFD43B 20px,
                    #111111 20px,
                    #111111 40px
                );
            }
            .hazard-tape-danger {
                background: repeating-linear-gradient(
                    -45deg,
                    #FF7A7A,
                    #FF7A7A 20px,
                    #111111 20px,
                    #111111 40px
                );
            }
        </style>
    </head>
    <body class="nb-grid-bg min-h-screen bg-paper font-sans text-ink antialiased">
        <!-- Top Hazard Caution Line -->
        <div class="hazard-tape border-b-4 border-ink py-2 text-center overflow-hidden">
            <div class="inline-block bg-ink px-4 py-1 font-display text-xs uppercase tracking-widest text-pop-yellow shadow-nb-sm">
                ⚠️ PERINGATAN RESMI // DO NOT CROSS // DILARANG MELINTAS // AREA PELANGGARAN ATURAN ⚠️
            </div>
        </div>

        @if (auth()->check() && auth()->user()->isMaster())
            <!-- Master Admin Action Bar -->
            <div class="border-b-4 border-ink bg-pop-yellow px-4 py-3">
                <div class="mx-auto flex max-w-2xl flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center gap-2">
                        <span class="nb-badge bg-pop-purple">Master Control</span>
                        <span class="text-xs font-bold uppercase">Melihat Halaman Banned (Admin Mode)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.users.index') }}" class="nb-btn nb-btn-ghost nb-btn-sm">
                            ← Panel User
                        </a>
                        <form method="POST" action="{{ route('admin.users.unban', $user) }}" onsubmit="return confirm('Pulihkan dan unban user ini?');">
                            @csrf
                            <button type="submit" class="nb-btn nb-btn-lime nb-btn-sm">
                                ✓ Unban Pengguna Ini
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        <main class="mx-auto w-full max-w-2xl px-4 py-8 sm:py-12">
            <!-- Warning Header Card -->
            <div class="relative mb-6">
                <!-- Diagonal Crime Scene Tape Banner -->
                <div class="pointer-events-none absolute -top-4 -left-4 -right-4 z-20 rotate-[-2deg] border-4 border-ink bg-pop-yellow py-1.5 px-3 text-center shadow-nb">
                    <p class="font-display text-xs sm:text-sm uppercase tracking-widest text-ink">
                        ⛔ DO NOT CROSS · POLICE LINE · DO NOT CROSS · POLICE LINE ⛔
                    </p>
                </div>

                <section class="nb-card overflow-hidden pt-8">
                    <!-- Top Section with Banned Stamp -->
                    <div class="border-b-4 border-ink bg-pop-red/20 px-5 py-8 text-center sm:px-8 relative">
                        <div class="relative mx-auto inline-block">
                            @if ($user->photo_profile)
                                <img src="{{ $user->photo_profile }}" alt="{{ $user->name }}" class="mx-auto h-28 w-28 border-4 border-ink object-cover grayscale opacity-60">
                            @else
                                <span class="mx-auto grid h-28 w-28 place-items-center border-4 border-ink bg-gray-200 font-display text-5xl text-ink/40 shadow-nb-sm">
                                    {{ Str::upper(Str::substr($user->name, 0, 1)) }}
                                </span>
                            @endif

                            <!-- Banned Stamp -->
                            <div class="absolute -bottom-2 -right-4 rotate-[-12deg] border-4 border-pop-red bg-white px-3 py-1 font-display text-xs sm:text-sm uppercase text-pop-red shadow-nb-sm">
                                BANNED ✕
                            </div>
                        </div>

                        <h1 class="mt-4 font-display text-2xl uppercase leading-none sm:text-3xl line-through text-ink/70">
                            {{ $user->name }}
                        </h1>
                        <p class="mt-1 text-sm font-bold text-ink/50">{{ '@'.$user->username }}</p>

                        <div class="mt-4 inline-flex items-center gap-2 border-3 border-ink bg-pop-red px-3 py-1 font-display text-xs uppercase text-ink shadow-nb-sm">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            AKUN DITANGGUHKAN / SUSPENDED
                        </div>
                    </div>

                    <!-- Ban Explanation & Do Not Cross Notice -->
                    <div class="bg-white p-6 sm:p-8 space-y-6">
                        <div class="border-4 border-ink bg-cream p-5 shadow-nb-sm">
                            <div class="flex items-center gap-2 border-b-2 border-ink pb-2 text-xs font-bold uppercase tracking-wider text-pop-red">
                                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <span>Pemberitahuan Pelanggaran Aturan</span>
                            </div>

                            <div class="mt-4 space-y-3">
                                <div>
                                    <span class="text-xs font-bold uppercase tracking-widest text-ink/60">Alasan Penindakan:</span>
                                    <p class="mt-1 font-bold text-base text-ink">
                                        {{ $user->ban_reason ?: 'Pengguna ini melanggar Pedoman Layanan dan Ketentuan Komunitas KLIKIN.' }}
                                    </p>
                                </div>

                                @if ($user->banned_at)
                                    <div>
                                        <span class="text-xs font-bold uppercase tracking-widest text-ink/60">Waktu Penindakan:</span>
                                        <p class="mt-0.5 text-xs font-bold text-ink/80">
                                            {{ $user->banned_at->format('d F Y, H:i') }} WIB
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Do Not Cross Visual Barricade -->
                        <div class="border-4 border-ink bg-pop-yellow/40 p-6 text-center space-y-4">
                            <div class="hazard-tape h-4 w-full border-2 border-ink"></div>

                            <div class="space-y-2">
                                <h2 class="font-display text-xl uppercase leading-tight sm:text-2xl text-ink">
                                    DO NOT CROSS · AKSES DITUTUP
                                </h2>
                                <p class="text-xs sm:text-sm font-medium leading-relaxed text-ink/80 max-w-lg mx-auto">
                                    Semua katalog produk affiliate, bio creator, dan tautan rekomendasi milik pengguna ini telah dibekukan. Tindakan tegas ini diambil guna melindungi pengunjung dari potensi penipuan, link berbahaya, atau aktivitas non-konsensus.
                                </p>
                            </div>

                            <div class="hazard-tape h-4 w-full border-2 border-ink"></div>
                        </div>

                        <!-- Action Button -->
                        <div class="text-center pt-2">
                            <a href="{{ route('home') }}" class="nb-btn nb-btn-primary w-full sm:w-auto">
                                ← Kembali ke Beranda KLIKIN
                            </a>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Bottom Hazard Caution Line -->
            <div class="hazard-tape-danger border-4 border-ink py-2 text-center shadow-nb-sm">
                <span class="bg-white px-3 py-0.5 text-[11px] font-display uppercase tracking-widest text-ink border-2 border-ink">
                    KLIKIN TRUST & SAFETY SYSTEM — ZERO TOLERANCE POLICY
                </span>
            </div>

            <footer class="mt-10 border-t-4 border-ink pt-5 text-center">
                <p class="text-xs font-bold uppercase tracking-widest text-ink/50">
                    Platform Rekomendasi Affiliate Aman & Terpercaya —
                    <a href="{{ route('home') }}" class="underline decoration-2 underline-offset-4 hover:bg-pop-yellow">{{ config('app.name', 'KLIKIN') }}</a>
                </p>
            </footer>
        </main>
    </body>
</html>

