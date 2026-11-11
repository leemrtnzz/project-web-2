<x-app-layout title="Edit Produk — {{ config('app.name', 'KLIKIN') }}">
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <a href="{{ route('products.index') }}" class="text-xs font-bold uppercase tracking-widest underline decoration-2 underline-offset-4">← Kembali ke Produk</a>
                <h1 class="nb-title mt-2 text-3xl sm:text-4xl">Edit Produk</h1>
            </div>
            <span class="nb-badge bg-pop-cyan">Total {{ $product->count }} klik</span>
        </div>
    </x-slot>

    <div class="grid gap-6 lg:grid-cols-[1.6fr_1fr]">
        <section class="nb-card p-5 sm:p-6">
            @include('products._form')
        </section>

        <aside class="nb-card h-fit bg-pop-pink p-5 sm:p-6">
            <h2 class="font-display text-xl uppercase leading-none">Pratinjau</h2>

            <div class="mt-4 border-4 border-ink bg-white">
                @if ($product->image)
                    <img src="{{ $product->image }}" alt="" class="aspect-square w-full border-b-4 border-ink object-cover">
                @else
                    <div class="nb-grid-bg grid aspect-square w-full place-items-center border-b-4 border-ink bg-pop-cyan">
                        <span class="font-display text-5xl">{{ Str::upper(Str::substr($product->title, 0, 1)) }}</span>
                    </div>
                @endif
                <div class="p-3">
                    <p class="text-[11px] font-bold uppercase tracking-widest text-ink/50">{{ $product->category->name }}</p>
                    <p class="mt-1 font-bold leading-snug">{{ $product->title }}</p>
                </div>
            </div>

            <a href="{{ route('profile.show', Auth::user()) }}" target="_blank" rel="noopener" class="nb-btn nb-btn-ghost mt-4 w-full">Lihat Halaman Publik</a>
        </aside>
    </div>
</x-app-layout>
