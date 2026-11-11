<x-app-layout title="Profil — {{ config('app.name', 'KLIKIN') }}">
    <x-slot name="header">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
            <h1 class="nb-title text-3xl sm:text-4xl">Profil</h1>
            <p class="text-sm font-bold uppercase tracking-widest text-ink/60">Atur identitas halaman publikmu</p>
        </div>
    </x-slot>

    <div class="grid gap-6 lg:grid-cols-[1.6fr_1fr]">
        <div class="space-y-6">
            <section class="nb-card p-5 sm:p-6">
                @include('profile.partials.update-profile-information-form')
            </section>

            <section class="nb-card p-5 sm:p-6">
                @include('profile.partials.update-password-form')
            </section>
        </div>

        <div class="space-y-6">
            <aside class="nb-card bg-pop-cyan p-5 sm:p-6">
                <h2 class="font-display text-xl uppercase leading-none">Pratinjau</h2>

                <div class="mt-4 border-4 border-ink bg-white p-4 text-center">
                    @if ($user->photo_profile)
                        <img src="{{ $user->photo_profile }}" alt="" class="mx-auto h-20 w-20 border-4 border-ink object-cover">
                    @else
                        <span class="mx-auto grid h-20 w-20 place-items-center border-4 border-ink bg-pop-purple font-display text-3xl">
                            {{ Str::upper(Str::substr($user->name, 0, 1)) }}
                        </span>
                    @endif

                    <p class="mt-3 font-display text-lg uppercase leading-tight">{{ $user->name }}</p>
                    <p class="text-xs font-bold text-ink/50">{{ '@'.$user->username }}</p>
                    <p class="mt-2 text-xs font-medium leading-relaxed text-ink/70">{{ $user->bio ?: 'Belum ada bio.' }}</p>
                </div>

                <a href="{{ route('profile.show', $user) }}" target="_blank" rel="noopener" class="nb-btn nb-btn-ghost mt-4 w-full">Buka Halaman</a>
            </aside>

            <section class="nb-card bg-pop-red/40 p-5 sm:p-6">
                @include('profile.partials.delete-user-form')
            </section>
        </div>
    </div>
</x-app-layout>
