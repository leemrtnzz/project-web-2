<x-app-layout title="Produk — {{ config('app.name', 'KLIKIN') }}">
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="nb-title text-3xl sm:text-4xl">Produk</h1>
                <p class="mt-1 text-sm font-bold uppercase tracking-widest text-ink/60">{{ $products->total() }} produk affiliate</p>
            </div>
            <a href="{{ route('products.create') }}" class="nb-btn nb-btn-primary">+ Tambah Produk</a>
        </div>
    </x-slot>

    @if ($products->isEmpty())
        <div class="border-4 border-dashed border-ink/30 p-10 text-center">
            <p class="font-display text-2xl uppercase">Belum ada produk</p>
            <p class="mx-auto mt-2 max-w-md text-sm font-medium text-ink/60">
                Mulai dengan menambahkan produk affiliate pertamamu. Jangan lupa buat kategori dulu ya.
            </p>
            <div class="mt-5 flex flex-wrap justify-center gap-3">
                <a href="{{ route('products.create') }}" class="nb-btn nb-btn-primary">Tambah Produk</a>
                <a href="{{ route('categories.index') }}" class="nb-btn nb-btn-ghost">Atur Kategori</a>
            </div>
        </div>
    @else
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($products as $product)
                <article class="nb-card nb-card-hover flex flex-col">
                    <div class="relative border-b-4 border-ink">
                        @if ($product->image)
                            <img src="{{ $product->image }}" alt="{{ $product->title }}" class="aspect-square w-full object-cover" loading="lazy">
                        @else
                            <div class="nb-grid-bg grid aspect-square w-full place-items-center bg-pop-cyan">
                                <span class="font-display text-5xl">{{ Str::upper(Str::substr($product->title, 0, 1)) }}</span>
                            </div>
                        @endif

                        <span class="nb-badge absolute left-2 top-2 bg-white">{{ $product->category->name }}</span>
                    </div>

                    <div class="flex flex-1 flex-col p-4">
                        <h3 class="text-base font-bold leading-snug">{{ $product->title }}</h3>
                        <p class="mt-1 truncate text-xs font-medium text-ink/50">{{ $product->affiliate_url }}</p>

                        <div class="mt-3 flex items-center justify-between gap-2">
                            <span class="nb-badge bg-pop-lime">{{ $product->count }} klik</span>
                            <a href="{{ route('products.redirect', $product) }}" target="_blank" rel="noopener" class="text-xs font-bold underline decoration-2 underline-offset-4 hover:bg-pop-yellow">
                                Tes link
                            </a>
                        </div>

                        <div class="mt-auto flex gap-2 border-t-4 border-ink pt-4">
                            <a href="{{ route('products.edit', $product) }}" class="nb-btn nb-btn-ghost nb-btn-sm flex-1">Edit</a>

                            <form method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('Hapus produk ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="nb-btn nb-btn-danger nb-btn-sm">Hapus</button>
                            </form>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        @if ($products->hasPages())
            <nav class="mt-8 flex items-center justify-between gap-3 border-t-4 border-ink pt-6" aria-label="Navigasi halaman">
                @if ($products->onFirstPage())
                    <span class="nb-btn nb-btn-ghost nb-btn-sm pointer-events-none opacity-40">← Sebelumnya</span>
                @else
                    <a href="{{ $products->previousPageUrl() }}" class="nb-btn nb-btn-ghost nb-btn-sm">← Sebelumnya</a>
                @endif

                <span class="nb-badge bg-pop-cyan">Halaman {{ $products->currentPage() }} / {{ $products->lastPage() }}</span>

                @if ($products->hasMorePages())
                    <a href="{{ $products->nextPageUrl() }}" class="nb-btn nb-btn-ghost nb-btn-sm">Berikutnya →</a>
                @else
                    <span class="nb-btn nb-btn-ghost nb-btn-sm pointer-events-none opacity-40">Berikutnya →</span>
                @endif
            </nav>
        @endif
    @endif
</x-app-layout>
