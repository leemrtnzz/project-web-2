@php
    $editing = isset($product) && $product !== null;
@endphp

<form method="POST" action="{{ $editing ? route('products.update', $product) : route('products.store') }}" class="space-y-5">
    @csrf
    @if ($editing)
        @method('PATCH')
    @endif

    <div>
        <x-input-label for="category_id" value="Kategori" />
        <select id="category_id" name="category_id" class="nb-input" required>
            <option value="" disabled @selected(old('category_id', $product?->category_id) === null)>Pilih kategori</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $product?->category_id) === $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('category_id')" />
        @if ($categories->isEmpty())
            <p class="mt-2 text-sm font-semibold text-[#D62828]">
                Belum ada kategori. <a href="{{ route('categories.index') }}" class="underline">Buat kategori dulu</a>.
            </p>
        @endif
    </div>

    <div>
        <x-input-label for="title" value="Nama Produk" />
        <x-text-input id="title" name="title" type="text" :value="old('title', $product?->title)" placeholder="Contoh: TWS Bluetooth Pro" maxlength="120" required />
        <x-input-error :messages="$errors->get('title')" />
    </div>

    <div>
        <x-input-label for="image" value="URL Gambar (opsional)" />
        <x-text-input id="image" name="image" type="url" :value="old('image', $product?->image)" placeholder="https://..." maxlength="2048" />
        <p class="mt-1 text-xs font-medium text-ink/50">Tempel tautan gambar produk. Boleh dari marketplace atau CDN mana pun.</p>
        <x-input-error :messages="$errors->get('image')" />
    </div>

    <div>
        <x-input-label for="affiliate_url" value="Link Affiliate" />
        <x-text-input id="affiliate_url" name="affiliate_url" type="url" :value="old('affiliate_url', $product?->affiliate_url)" placeholder="https://shopee.co.id/..." maxlength="2048" required />
        <p class="mt-1 text-xs font-medium text-ink/50">Pengunjung akan diarahkan ke link ini saat menekan tombol beli.</p>
        <x-input-error :messages="$errors->get('affiliate_url')" />
    </div>

    <div class="flex flex-wrap items-center gap-3 border-t-4 border-ink pt-5">
        <x-primary-button>{{ $editing ? 'Simpan Perubahan' : 'Tambah Produk' }}</x-primary-button>
        <a href="{{ route('products.index') }}" class="nb-btn nb-btn-ghost">Batal</a>
    </div>
</form>
