<section class="space-y-5">
    <header>
        <h2 class="font-display text-xl uppercase leading-none">
            {{ __('Hapus Akun') }}
        </h2>

        <p class="mt-1 text-sm font-medium text-ink/70">
            {{ __('Setelah dihapus, semua kategori, produk, dan data kamu akan hilang permanen.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Hapus Akun') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="font-display text-xl uppercase leading-tight">
                {{ __('Yakin ingin menghapus akun?') }}
            </h2>

            <p class="mt-2 text-sm font-medium text-ink/70">
                {{ __('Masukkan password untuk konfirmasi. Tindakan ini tidak bisa dibatalkan.') }}
            </p>

            <div class="mt-5">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-danger-button>
                    {{ __('Hapus Akun') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
