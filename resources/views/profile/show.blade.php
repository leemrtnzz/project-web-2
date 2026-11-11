<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $user->name }} ({{ '@'.$user->username }}) — {{ config('app.name', 'KLIKIN') }}</title>
        <meta name="description" content="{{ $user->bio ?: 'Rekomendasi produk affiliate dari '.$user->name }}">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=archivo-black:400|space-grotesk:400,500,600,700" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="nb-grid-bg min-h-screen bg-paper font-sans text-ink antialiased">
        <main class="mx-auto w-full max-w-2xl px-4 py-8 sm:py-10">
                <section class="nb-card overflow-hidden">
                    <div class="border-b-4 border-ink bg-pop-purple px-5 py-6 text-center sm:px-8">
                        @if ($user->photo_profile)
                            <img src="{{ $user->photo_profile }}" alt="{{ $user->name }}" class="mx-auto h-28 w-28 border-4 border-ink object-cover shadow-nb-sm">
                        @else
                            <span class="mx-auto grid h-28 w-28 place-items-center border-4 border-ink bg-pop-yellow font-display text-5xl shadow-nb-sm">
                                {{ Str::upper(Str::substr($user->name, 0, 1)) }}
                            </span>
                        @endif

                        <h1 class="mt-4 font-display text-2xl uppercase leading-none sm:text-3xl">{{ $user->name }}</h1>
                        <p class="mt-1 text-sm font-bold text-ink/60">{{ '@'.$user->username }}</p>

                        @if ($user->bio)
                            <p class="mx-auto mt-3 max-w-md text-sm font-medium leading-relaxed text-ink/80">{{ $user->bio }}</p>
                        @endif
                    </div>

                    <div
                        x-data="{
                            copied: false,
                            url: @js(route('profile.show', $user)),
                            copy() {
                                navigator.clipboard.writeText(this.url);
                                this.copied = true;
                                setTimeout(() => this.copied = false, 1600);
                            }
                        }"
                        class="flex flex-col gap-2 bg-white p-4 sm:flex-row"
                    >
                        <input type="text" readonly value="{{ route('profile.show', $user) }}" class="nb-input flex-1 truncate bg-paper text-xs">
                        <button type="button" @click="copy()" class="nb-btn nb-btn-primary nb-btn-sm shrink-0" x-text="copied ? 'Tersalin!' : 'Bagikan'"></button>
                    </div>
                </section>

                @forelse ($productsByCategory as $categoryName => $products)
                    <section class="mt-8">
                        <div class="mb-3 flex items-center gap-3">
                            <h2 class="font-display text-lg uppercase leading-none sm:text-xl">{{ $categoryName }}</h2>
                            <span class="nb-badge bg-pop-cyan">{{ $products->count() }} produk</span>
                        </div>

                        <div class="space-y-3">
                            @foreach ($products as $product)
                                <a href="{{ route('products.redirect', $product) }}" rel="nofollow sponsored noopener" class="group flex items-center gap-3 border-4 border-ink bg-white p-3 shadow-nb-sm transition hover:-translate-x-0.5 hover:-translate-y-0.5 hover:bg-cream hover:shadow-nb">
                                    @if ($product->image)
                                        <img src="{{ $product->image }}" alt="{{ $product->title }}" class="h-20 w-20 shrink-0 border-4 border-ink object-cover" loading="lazy">
                                    @else
                                        <span class="nb-grid-bg grid h-20 w-20 shrink-0 place-items-center border-4 border-ink bg-pop-cyan font-display text-2xl">
                                            {{ Str::upper(Str::substr($product->title, 0, 1)) }}
                                        </span>
                                    @endif

                                    <div class="min-w-0 flex-1">
                                        <h3 class="text-sm font-bold leading-snug sm:text-base">{{ $product->title }}</h3>
                                        <p class="mt-1 text-[11px] font-bold uppercase tracking-widest text-ink/50">{{ $product->category->name }}</p>
                                        <span class="nb-badge mt-2 bg-pop-lime">Beli Sekarang</span>
                                    </div>

                                    <svg class="h-6 w-6 shrink-0 transition group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M5 12h14M13 6l6 6-6 6" />
                                    </svg>
                                </a>
                            @endforeach
                        </div>
                    </section>
                @empty
                    <div class="mt-8 border-4 border-dashed border-ink/30 p-10 text-center">
                        <p class="font-display text-xl uppercase">Belum ada produk</p>
                        <p class="mt-2 text-sm font-medium text-ink/60">Halaman ini belum menambahkan produk affiliate.</p>
                    </div>
                @endforelse

                <footer class="mt-12 border-t-4 border-ink pt-5 text-center">
                    <p class="text-xs font-bold uppercase tracking-widest text-ink/50">
                        Dibuat dengan
                        <a href="{{ route('home') }}" class="underline decoration-2 underline-offset-4 hover:bg-pop-yellow">{{ config('app.name', 'KLIKIN') }}</a>
                    </p>
                    <p class="mt-1 text-[10px] font-medium uppercase tracking-widest text-ink/40">
                        Sebagian tautan adalah link affiliate.
                    </p>
                </footer>
            </main>
    </body>
</html>
