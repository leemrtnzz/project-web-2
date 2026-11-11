<x-app-layout title="Tambah Produk — {{ config('app.name', 'KLIKIN') }}">
    <x-slot name="header">
        <div>
            <a href="{{ route('products.index') }}" class="text-xs font-bold uppercase tracking-widest underline decoration-2 underline-offset-4">← Kembali ke Produk</a>
            <h1 class="nb-title mt-2 text-3xl sm:text-4xl">Tambah Produk</h1>
        </div>
    </x-slot>

    <div class="grid gap-6 lg:grid-cols-[1.6fr_1fr]">
        <section class="nb-card p-5 sm:p-6">
            @include('products._form', ['product' => null])
        </section>

        <aside class="nb-card h-fit bg-pop-yellow p-5 sm:p-6">
            <h2 class="font-display text-xl uppercase leading-none">Tips</h2>
            <ul class="mt-4 space-y-3 text-sm font-medium text-ink/80">
                <li class="flex gap-2"><span class="font-bold">1.</span> Pakai nama produk yang jelas dan spesifik.</li>
                <li class="flex gap-2"><span class="font-bold">2.</span> Gunakan gambar persegi supaya tampilan publik rapi.</li>
                <li class="flex gap-2"><span class="font-bold">3.</span> Pastikan link affiliate bisa dibuka tanpa login.</li>
                <li class="flex gap-2"><span class="font-bold">4.</span> Kelompokkan produk per kategori agar mudah dicari.</li>
            </ul>
        </aside>
    </div>
</x-app-layout>
