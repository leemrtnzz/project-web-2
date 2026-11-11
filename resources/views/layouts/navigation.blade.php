<nav x-data="{ open: false }" class="sticky top-0 z-40 border-b-4 border-ink bg-paper">
    <div class="mx-auto flex h-20 max-w-6xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-4 lg:gap-8">
            <a href="{{ route('dashboard') }}" class="shrink-0">
                <x-application-logo />
            </a>

            <div class="hidden items-center gap-1 md:flex">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-nav-link>
                <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                    {{ __('Produk') }}
                </x-nav-link>
                <x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">
                    {{ __('Kategori') }}
                </x-nav-link>
                <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                    {{ __('Profil') }}
                </x-nav-link>
                @if (Auth::user()->isMaster())
                    <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                        <span class="inline-flex items-center gap-1.5">
                            {{ __('Kelola Pengguna') }}
                            <!-- <span class="nb-badge bg-pop-purple text-[10px] px-1.5 py-0.5">Master</span> -->
                        </span>
                    </x-nav-link>
                @endif
            </div>
        </div>

        <div class="hidden items-center gap-3 md:flex">
            <!-- <a href="{{ route('profile.show', Auth::user()) }}" target="_blank" rel="noopener" class="nb-btn nb-btn-cyan nb-btn-sm">
                {{ __('Lihat Halaman') }}
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M7 17 17 7M9 7h8v8" />
                </svg>
            </a> -->

            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="flex items-center gap-2 border-4 border-ink bg-white px-2 py-1.5 font-bold shadow-nb-sm transition hover:bg-pop-yellow focus:outline-none">
                        @if (Auth::user()->photo_profile)
                            <img src="{{ Auth::user()->photo_profile }}" alt="" class="h-8 w-8 border-2 border-ink object-cover">
                        @else
                            <span class="grid h-8 w-8 place-items-center border-2 border-ink bg-pop-pink font-display text-sm leading-none">
                                {{ Str::upper(Str::substr(Auth::user()->name, 0, 1)) }}
                            </span>
                        @endif

                        <span class="max-w-[8rem] truncate text-sm">{{ Auth::user()->name }}</span>

                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <div class="border-b-4 border-ink bg-cream px-4 py-3">
                        <div class="flex items-center justify-between gap-1">
                            <p class="truncate text-sm font-bold">{{ Auth::user()->name }}</p>
                            @if (Auth::user()->isMaster())
                                <span class="nb-badge bg-pop-purple text-[9px] px-1 py-0.5">MASTER</span>
                            @else
                                <span class="nb-badge bg-white text-[9px] px-1 py-0.5">USER</span>
                            @endif
                        </div>
                        <p class="truncate text-xs font-medium text-ink/60">{{ '@'.Auth::user()->username }}</p>
                    </div>

                    @if (Auth::user()->isMaster())
                        <x-dropdown-link :href="route('admin.users.index')">
                            {{ __('Kelola Pengguna') }}
                        </x-dropdown-link>
                    @endif

                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Pengaturan Profil') }}
                    </x-dropdown-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Keluar') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>

        <div class="flex items-center md:hidden">
            <button @click="open = ! open" class="grid h-11 w-11 place-items-center border-4 border-ink bg-pop-yellow shadow-nb-sm" aria-label="{{ __('Buka menu') }}">
                <svg x-show="! open" class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-show="open" x-cloak class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <div x-show="open" x-cloak x-transition class="border-t-4 border-ink bg-paper px-4 pb-5 pt-3 md:hidden">
        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            {{ __('Dashboard') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
            {{ __('Produk') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">
            {{ __('Kategori') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
            {{ __('Profil') }}
        </x-responsive-nav-link>
        @if (Auth::user()->isMaster())
            <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                <span class="inline-flex items-center gap-1.5">
                    {{ __('Kelola Pengguna') }}
                    <!-- <span class="nb-badge bg-pop-purple text-[10px] px-1.5 py-0.5">Master</span> -->
                </span>
            </x-responsive-nav-link>
        @endif

        <div class="mt-4 border-t-4 border-ink pt-4">
            <div class="mb-3 flex items-center gap-3">
                @if (Auth::user()->photo_profile)
                    <img src="{{ Auth::user()->photo_profile }}" alt="" class="h-10 w-10 border-2 border-ink object-cover">
                @else
                    <span class="grid h-10 w-10 place-items-center border-2 border-ink bg-pop-pink font-display leading-none">
                        {{ Str::upper(Str::substr(Auth::user()->name, 0, 1)) }}
                    </span>
                @endif
                <div class="min-w-0">
                    <p class="truncate text-sm font-bold">{{ Auth::user()->name }}</p>
                    <p class="truncate text-xs text-ink/60">{{ Auth::user()->email }}</p>
                </div>
            </div>

            <!-- <a href="{{ route('profile.show', Auth::user()) }}" target="_blank" rel="noopener" class="nb-btn nb-btn-cyan mb-2 w-full">
                {{ __('Lihat Halaman Publik') }}
            </a> -->

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nb-btn nb-btn-ghost w-full">
                    {{ __('Keluar') }}
                </button>
            </form>
        </div>
    </div>
</nav>
