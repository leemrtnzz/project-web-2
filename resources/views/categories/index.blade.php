<x-app-layout title="Kategori — {{ config('app.name', 'KLIKIN') }}">
    <x-slot name="header">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
            <h1 class="nb-title text-3xl sm:text-4xl">Kategori</h1>
            <p class="text-sm font-bold uppercase tracking-widest text-ink/60">{{ $categories->count() }} kategori</p>
        </div>
    </x-slot>

    <div class="space-y-8">
        <section class="nb-card bg-pop-yellow p-5 sm:p-6">
            <h2 class="font-display text-xl uppercase leading-none">Tambah Kategori</h2>
            <p class="mt-1 text-sm font-medium text-ink/70">Kelompokkan produkmu biar halaman publik lebih rapi.</p>

            <form method="POST" action="{{ route('categories.store') }}" class="mt-4 flex flex-col gap-3 sm:flex-row">
                @csrf
                <div class="flex-1">
                    <x-text-input id="name" name="name" type="text" :value="old('name')" placeholder="Contoh: Gadget" maxlength="60" required />
                    <x-input-error :messages="$errors->get('name')" />
                </div>
                <x-primary-button class="shrink-0">Tambah</x-primary-button>
            </form>
        </section>

        @if ($categories->isEmpty())
            <div class="border-4 border-dashed border-ink/30 p-10 text-center">
                <p class="font-display text-xl uppercase">Belum ada kategori</p>
                <p class="mt-2 text-sm font-medium text-ink/60">Tambahkan kategori pertama lewat form di atas.</p>
            </div>
        @else
            <section class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($categories as $category)
                    <article class="nb-card nb-card-hover flex flex-col gap-4 p-5">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <h3 class="truncate font-display text-xl uppercase leading-tight">{{ $category->name }}</h3>
                                <p class="mt-1 text-xs font-bold uppercase tracking-widest text-ink/50">
                                    {{ $category->affiliate_products_count }} produk
                                </p>
                            </div>
                            <a href="{{ route('products.create') }}" class="nb-badge shrink-0 bg-pop-cyan">Tambah</a>
                        </div>

                        <form method="POST" action="{{ route('categories.update', $category) }}" class="flex flex-col gap-2 border-t-4 border-ink pt-4">
                            @csrf
                            @method('PATCH')
                            <label for="category-{{ $category->id }}" class="sr-only">Nama kategori</label>
                            <div class="flex gap-2">
                                <input id="category-{{ $category->id }}" name="name" type="text" value="{{ $category->name }}" maxlength="60" required class="nb-input flex-1 px-2 py-1.5 text-xs">
                                <button type="submit" class="nb-btn nb-btn-lime nb-btn-sm">Simpan</button>
                            </div>
                        </form>

                        <form method="POST" action="{{ route('categories.destroy', $category) }}" onsubmit="return confirm('Hapus kategori ini? Semua produk di dalamnya juga akan terhapus.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="nb-btn nb-btn-danger nb-btn-sm w-full">Hapus Kategori</button>
                        </form>
                    </article>
                @endforeach
            </section>
        @endif
    </div>
</x-app-layout>
