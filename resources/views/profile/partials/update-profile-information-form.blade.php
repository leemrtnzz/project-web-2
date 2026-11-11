<section>
    <header>
        <h2 class="font-display text-xl uppercase leading-none">
            {{ __('Informasi Profil') }}
        </h2>

        <p class="mt-1 text-sm font-medium text-ink/60">
            {{ __('Data ini tampil di halaman publik kamu.') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-5">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Nama')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="username" :value="__('Username')" />
            <div class="flex items-center gap-0">
                <span class="grid shrink-0 place-items-center self-stretch border-4 border-r-0 border-ink bg-pop-yellow px-3 text-sm font-bold">
                    /u/
                </span>
                <x-text-input id="username" name="username" type="text" class="mt-0 block w-full" :value="old('username', $user->username)" required autocomplete="username" maxlength="30" />
            </div>
            <p class="mt-1 text-xs font-medium text-ink/50">Huruf kecil, angka, tanda hubung, atau garis bawah. Minimal 3 karakter.</p>
            <x-input-error class="mt-2" :messages="$errors->get('username')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="mt-2 text-sm text-ink">
                        {{ __('Email kamu belum terverifikasi.') }}

                        <button form="send-verification" class="nb-link">
                            {{ __('Kirim ulang email verifikasi.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm font-bold text-[#1B7A3A]">
                            {{ __('Tautan verifikasi baru telah dikirim ke email kamu.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="bio" :value="__('Bio')" />
            <textarea id="bio" name="bio" rows="3" maxlength="160" class="nb-input" placeholder="Ceritakan singkat tentang kamu atau rekomendasimu...">{{ old('bio', $user->bio) }}</textarea>
            <p class="mt-1 text-xs font-medium text-ink/50">Maksimal 160 karakter.</p>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        <div>
            <x-input-label for="photo_profile" :value="__('URL Foto Profil (opsional)')" />
            <x-text-input id="photo_profile" name="photo_profile" type="url" class="mt-1 block w-full" :value="old('photo_profile', $user->photo_profile)" placeholder="https://..." maxlength="2048" />
            <p class="mt-1 text-xs font-medium text-ink/50">Tempel tautan foto persegi agar tampil rapi.</p>
            <x-input-error class="mt-2" :messages="$errors->get('photo_profile')" />
        </div>

        <div class="flex flex-wrap items-center gap-4 border-t-4 border-ink pt-5">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="nb-badge bg-pop-lime"
                >{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>
