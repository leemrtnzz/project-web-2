<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'KLIKIN') }} — Link affiliate, sat-set.</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=archivo-black:400|space-grotesk:400,500,600,700" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-paper font-sans text-ink antialiased">
        <header class="sticky top-0 z-40 border-b-4 border-ink bg-paper">
            <div class="mx-auto flex h-20 max-w-6xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
                <a href="{{ route('home') }}">
                    <x-application-logo />
                </a>

                <nav class="flex items-center gap-2 sm:gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="nb-btn nb-btn-primary nb-btn-sm sm:text-sm">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="nb-btn nb-btn-ghost nb-btn-sm sm:text-sm">Masuk</a>
                        <a href="{{ route('register') }}" class="nb-btn nb-btn-primary nb-btn-sm sm:text-sm">Daftar</a>
                    @endauth
                </nav>
            </div>
        </header>

        <main>
            <section class="nb-grid-bg border-b-4 border-ink">
                <div class="mx-auto grid max-w-6xl items-center gap-10 px-4 py-14 sm:px-6 lg:grid-cols-2 lg:gap-14 lg:px-8 lg:py-20">
                    <div>
                        <span class="nb-badge mb-5 bg-pop-lime">Affiliate · Link in bio</span>

                        <h1 class="nb-title text-5xl sm:text-6xl lg:text-7xl">
                            Satu link buat semua
                            <span class="inline-block -rotate-1 border-4 border-ink bg-pop-yellow px-2 shadow-nb">rekomendasi</span>
                            kamu.
                        </h1>

                        <p class="mt-6 max-w-xl text-base font-medium leading-relaxed text-ink/80 sm:text-lg">
                            Kumpulkan semua produk affiliate favoritmu dalam satu halaman. Rapikan per kategori,
                            bagikan satu link, dan pantau kliknya. Tanpa ribet.
                        </p>

                        <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                            @auth
                                <a href="{{ route('dashboard') }}" class="nb-btn nb-btn-primary">Buka Dashboard</a>
                            @else
                                <a href="{{ route('register') }}" class="nb-btn nb-btn-primary">Buat Halaman Gratis</a>
                            @endauth
                            <a href="{{ route('profile.show', 'demo') }}" class="nb-btn nb-btn-cyan">Lihat Demo</a>
                        </div>

                        <div class="mt-8 flex flex-wrap items-center gap-x-6 gap-y-2 text-xs font-bold uppercase tracking-widest text-ink/60">
                            <span>✓ Gratis selamanya</span>
                            <span>✓ Kelola kategori</span>
                            <span>✓ Hitung klik</span>
                        </div>
                    </div>

                    <div class="relative mx-auto w-full max-w-sm">
                        <div class="absolute -left-3 -top-3 h-full w-full border-4 border-ink bg-pop-pink"></div>
                        <div class="relative border-4 border-ink bg-white shadow-nb-lg">
                            <div class="flex items-center justify-between border-b-4 border-ink bg-pop-yellow px-4 py-2">
                                <span class="font-display text-xs uppercase tracking-widest">klikin.bio/u/demo</span>
                                <span class="flex gap-1">
                                    <span class="h-3 w-3 border-2 border-ink bg-pop-red"></span>
                                    <span class="h-3 w-3 border-2 border-ink bg-pop-cyan"></span>
                                </span>
                            </div>

                            <div class="p-5">
                                <div class="flex items-center gap-3">
                                    <div class="grid h-14 w-14 place-items-center border-4 border-ink bg-pop-purple font-display text-xl">D</div>
                                    <div>
                                        <p class="font-display text-lg uppercase leading-none">Demo Creator</p>
                                        <p class="mt-1 text-xs font-bold text-ink/60">@demo</p>
                                    </div>
                                </div>

                                <p class="mt-3 text-xs font-medium leading-relaxed text-ink/70">
                                    Rekomendasi produk pilihan yang bikin hidup makin gampang.
                                </p>

                                <div class="mt-4 space-y-3">
                                    <div class="flex items-center gap-3 border-4 border-ink bg-cream p-2 shadow-nb-sm">
                                        <span class="grid h-11 w-11 place-items-center border-2 border-ink bg-pop-cyan text-lg">🎧</span>
                                        <div class="min-w-0 flex-1">
                                            <p class="truncate text-sm font-bold">TWS Bluetooth Pro</p>
                                            <p class="text-[10px] font-bold uppercase tracking-widest text-ink/50">Gadget</p>
                                        </div>
                                        <span class="nb-badge bg-pop-lime">Beli</span>
                                    </div>
                                    <div class="flex items-center gap-3 border-4 border-ink bg-cream p-2 shadow-nb-sm">
                                        <span class="grid h-11 w-11 place-items-center border-2 border-ink bg-pop-pink text-lg">🧴</span>
                                        <div class="min-w-0 flex-1">
                                            <p class="truncate text-sm font-bold">Sunscreen SPF 50</p>
                                            <p class="text-[10px] font-bold uppercase tracking-widest text-ink/50">Kecantikan</p>
                                        </div>
                                        <span class="nb-badge bg-pop-lime">Beli</span>
                                    </div>
                                    <div class="flex items-center gap-3 border-4 border-ink bg-cream p-2 shadow-nb-sm">
                                        <span class="grid h-11 w-11 place-items-center border-2 border-ink bg-pop-yellow text-lg">🍳</span>
                                        <div class="min-w-0 flex-1">
                                            <p class="truncate text-sm font-bold">Air Fryer 5L</p>
                                            <p class="text-[10px] font-bold uppercase tracking-widest text-ink/50">Rumah Tangga</p>
                                        </div>
                                        <span class="nb-badge bg-pop-lime">Beli</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="border-b-4 border-ink bg-white">
                <div class="mx-auto max-w-6xl px-4 py-14 sm:px-6 lg:px-8">
                    <h2 class="nb-title text-3xl sm:text-4xl">Kenapa pakai Klikin?</h2>

                    <div class="mt-8 grid gap-6 md:grid-cols-3">
                        <div class="nb-card nb-card-hover bg-pop-cyan p-6">
                            <span class="grid h-12 w-12 place-items-center border-4 border-ink bg-white font-display text-xl">01</span>
                            <h3 class="mt-4 text-xl font-bold">Satu link, semua produk</h3>
                            <p class="mt-2 text-sm font-medium text-ink/75">Nggak perlu kirim link satu-satu ke chat. Cukup bagikan satu halaman berisi semua rekomendasimu.</p>
                        </div>
                        <div class="nb-card nb-card-hover bg-pop-pink p-6">
                            <span class="grid h-12 w-12 place-items-center border-4 border-ink bg-white font-display text-xl">02</span>
                            <h3 class="mt-4 text-xl font-bold">Rapi per kategori</h3>
                            <p class="mt-2 text-sm font-medium text-ink/75">Pisahkan gadget, kecantikan, atau kategori lain agar pengunjung gampang menemukan produknya.</p>
                        </div>
                        <div class="nb-card nb-card-hover bg-pop-yellow p-6">
                            <span class="grid h-12 w-12 place-items-center border-4 border-ink bg-white font-display text-xl">03</span>
                            <h3 class="mt-4 text-xl font-bold">Pantau klik</h3>
                            <p class="mt-2 text-sm font-medium text-ink/75">Lihat produk mana yang paling sering diklik, lalu optimalkan rekomendasimu.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="bg-paper">
                <div class="mx-auto max-w-6xl px-4 py-16 text-center sm:px-6 lg:px-8">
                    <h2 class="nb-title mx-auto max-w-3xl text-4xl sm:text-5xl">
                        Siap punya halaman affiliate sendiri?
                    </h2>
                    <p class="mx-auto mt-4 max-w-xl text-base font-medium text-ink/70">
                        Daftar sekarang, tambahkan produk pertamamu, dan bagikan link-nya dalam hitungan menit.
                    </p>
                    <div class="mt-8 flex flex-wrap justify-center gap-3">
                        @auth
                            <a href="{{ route('dashboard') }}" class="nb-btn nb-btn-primary">Ke Dashboard</a>
                        @else
                            <a href="{{ route('register') }}" class="nb-btn nb-btn-primary">Daftar Sekarang</a>
                            <a href="{{ route('login') }}" class="nb-btn nb-btn-ghost">Sudah Punya Akun</a>
                        @endauth
                    </div>
                </div>
            </section>
        </main>

        <footer class="border-t-4 border-ink bg-[#FFD93D] text-ink">
  <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">

    <!-- Atas: brand + CTA -->
    <div class="flex flex-col gap-6 sm:flex-row sm:items-start sm:justify-between">
      <div class="max-w-xs">
        <span class="block text-3xl font-extrabold tracking-tight">KLIKIN</span>
        <p class="mt-2 text-sm font-semibold leading-snug">
          Platform affiliate untuk mempromosikan produk dan menghasilkan pendapatan dari penjualan.
        </p>
      </div>

      <a href="{{ route('register') }}"
         class="inline-flex w-fit items-center border-2 border-ink bg-ink px-6 py-3 text-sm font-extrabold uppercase tracking-wide text-[#FFD93D] shadow-[4px_4px_0_0_#fff] transition hover:translate-x-0.5 hover:translate-y-0.5 hover:shadow-none">
        Daftar Gratis →
      </a>
    </div>

    <!-- Kartu -->
    <div class="mt-10 grid gap-6 md:grid-cols-2">
      <div class="border-2 border-ink bg-white p-4 shadow-[6px_6px_0_0_#111]">
        <span class="block text-[11px] font-extrabold uppercase tracking-widest">Hubungi Kami</span>
        <div class="flex items-center gap-2 text-sm font-semibold">
            <span class="mt-3 flex items-center gap-2 text-sm font-semibold"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M9 22H15C20 22 22 20 22 15V9C22 4 20 2 15 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 15.5C13.933 15.5 15.5 13.933 15.5 12C15.5 10.067 13.933 8.5 12 8.5C10.067 8.5 8.5 10.067 8.5 12C8.5 13.933 10.067 15.5 12 15.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M17.6361 7H17.6477" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
            <a href="https://www.instagram.com/klikin.co"
               class="mt-3 block text-sm font-semibold hover:underline ">
              @klikin.co
            </a>
        </div>
        <div class="flex items-center gap-2 text-sm font-semibold">
            <span class="mt-3 flex items-center gap-2 text-sm font-semibold"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M8.5 19H8C4 19 2 18 2 13V8C2 4 4 2 8 2H16C20 2 22 4 22 8V13C22 17 20 19 16 19H15.5C15.19 19 14.89 19.15 14.7 19.4L13.2 21.4C12.54 22.28 11.46 22.28 10.8 21.4L9.3 19.4C9.14 19.18 8.77 19 8.5 19Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/><path d="M15.9965 11H16.0054" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M11.9955 11H12.0045" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M7.99451 11H8.00349" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
            <a href="mailto:admin@klikin.co"
               class="mt-3 block text-sm font-semibold hover:underline ">
              admin@klikin.co
            </a>
        </div>
      </div>

      <div class="border-2 border-ink bg-white p-4 shadow-[6px_6px_0_0_#111]">
        <span class="block text-[11px] font-extrabold uppercase tracking-widest">Tentang Kami</span>
        <p class="mt-3 text-sm font-semibold leading-snug">
          Kami adalah platform affiliate yang membantu Anda mempromosikan produk dan menghasilkan pendapatan dari penjualan yang sukses.
        </p>
      </div>
    </div>

    <!-- Bawah -->
    <div class="mt-10 flex items-center justify-between border-t-2 border-ink pt-4 text-[11px] font-extrabold uppercase tracking-wide">
      <span>© {{ date('Y') }} KLIKIN</span>
      <div class="flex gap-4">
        <a href="#" class="hover:underline">Privasi</a>
        <a href="#" class="hover:underline">Syarat</a>
      </div>
    </div>

  </div>
</footer>
    </body>
</html>
