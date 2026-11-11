<x-app-layout title="Dashboard — {{ config('app.name', 'KLIKIN') }}">
    <x-slot name="header">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
            <h1 class="nb-title text-3xl sm:text-4xl">Dashboard</h1>
            <p class="text-sm font-bold uppercase tracking-widest text-ink/60">Halo, {{ Auth::user()->name }}</p>
        </div>
    </x-slot>

    <div class="space-y-8">
        <section class="nb-card bg-pop-purple p-5 sm:p-6">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-widest text-ink/70">Link halaman publik kamu</p>
                    <p class="mt-1 font-display text-xl uppercase leading-tight break-all">
                        {{ route('profile.show', Auth::user()) }}
                    </p>
                </div>

                <div x-data="{
                        copied: false,
                        url: @js(route('profile.show', Auth::user())),
                        copy() {
                            navigator.clipboard.writeText(this.url);
                            this.copied = true;
                            setTimeout(() => this.copied = false, 1600);
                        }
                    }"
                    class="flex flex-col gap-2 sm:flex-row"
                >
                    <button type="button" @click="copy()" class="nb-btn nb-btn-primary" x-text="copied ? 'Tersalin!' : 'Salin Link'"></button>
                    <a href="{{ route('profile.show', Auth::user()) }}" target="_blank" rel="noopener" class="nb-btn nb-btn-ghost">
                        Buka Halaman
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M7 17 17 7M9 7h8v8" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        <section class="grid gap-5 sm:grid-cols-3">
            <div class="nb-card bg-pop-cyan p-5">
                <p class="text-xs font-bold uppercase tracking-widest text-ink/70">Total Produk</p>
                <p class="mt-2 font-display text-4xl">{{ $productCount }}</p>
                <a href="{{ route('products.index') }}" class="mt-3 inline-block text-xs font-bold uppercase tracking-wide underline decoration-2 underline-offset-4">Kelola produk</a>
            </div>
            <div class="nb-card bg-pop-pink p-5">
                <p class="text-xs font-bold uppercase tracking-widest text-ink/70">Kategori</p>
                <p class="mt-2 font-display text-4xl">{{ $categoryCount }}</p>
                <a href="{{ route('categories.index') }}" class="mt-3 inline-block text-xs font-bold uppercase tracking-wide underline decoration-2 underline-offset-4">Kelola kategori</a>
            </div>
            <div class="nb-card bg-pop-yellow p-5">
                <p class="text-xs font-bold uppercase tracking-widest text-ink/70">Total Klik</p>
                <p class="mt-2 font-display text-4xl">{{ number_format($clickCount) }}</p>
                <span class="mt-3 inline-block text-xs font-bold uppercase tracking-wide text-ink/60">Dari semua produk</span>
            </div>
        </section>

        <section class="grid gap-6 lg:grid-cols-[1.4fr_1fr]">
            <div class="nb-card p-5 sm:p-6">
                <div class="flex items-center justify-between gap-3">
                    <h2 class="font-display text-xl uppercase leading-none">Produk Terbaru</h2>
                    <a href="{{ route('products.create') }}" class="nb-btn nb-btn-primary nb-btn-sm">+ Produk</a>
                </div>

                @if ($recentProducts->isEmpty())
                    <div class="mt-6 border-4 border-dashed border-ink/30 p-8 text-center">
                        <p class="font-bold">Belum ada produk.</p>
                        <p class="mt-1 text-sm text-ink/60">Tambahkan produk affiliate pertamamu sekarang.</p>
                        <a href="{{ route('products.create') }}" class="nb-btn nb-btn-cyan mt-4">Tambah Produk</a>
                    </div>
                @else
                    <div class="mt-5 grid gap-4 sm:grid-cols-2">
                        @foreach ($recentProducts as $product)
                            <a href="{{ route('products.edit', $product) }}" class="flex items-center gap-3 border-4 border-ink bg-cream p-3 shadow-nb-sm transition hover:-translate-y-0.5 hover:shadow-nb">
                                @if ($product->image)
                                    <img src="{{ $product->image }}" alt="" class="h-12 w-12 shrink-0 border-2 border-ink object-cover" loading="lazy">
                                @else
                                    <span class="grid h-12 w-12 shrink-0 place-items-center border-2 border-ink bg-pop-cyan font-display text-lg">
                                        {{ Str::upper(Str::substr($product->title, 0, 1)) }}
                                    </span>
                                @endif
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-bold">{{ $product->title }}</p>
                                    <p class="text-[11px] font-bold uppercase tracking-widest text-ink/50">{{ $product->category->name }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="nb-card p-5 sm:p-6">
                <h2 class="font-display text-xl uppercase leading-none">Paling Banyak Diklik</h2>

                @if ($topProducts->isEmpty())
                    <p class="mt-5 text-sm text-ink/60">Belum ada data klik.</p>
                @else
                    <ol class="mt-5 space-y-3">
                        @foreach ($topProducts as $index => $product)
                            <li class="flex items-center gap-3">
                                <span class="grid h-8 w-8 shrink-0 place-items-center border-2 border-ink bg-pop-yellow text-sm font-bold">{{ $index + 1 }}</span>
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-bold">{{ $product->title }}</p>
                                    <p class="text-[11px] font-bold uppercase tracking-widest text-ink/50">{{ $product->category->name }}</p>
                                </div>
                                <span class="nb-badge shrink-0 bg-pop-lime">{{ $product->count }} klik</span>
                            </li>
                        @endforeach
                    </ol>
                @endif
            </div>
        </section>
    </div>
</x-app-layout>
