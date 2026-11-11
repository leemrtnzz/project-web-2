<x-app-layout title="Kelola Pengguna — Master Administrator">
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="flex items-center gap-2">
                    <h1 class="nb-title text-2xl sm:text-3xl">Kelola Pengguna</h1>
                    <!-- <span class="nb-badge bg-pop-purple">Master Panel</span> -->
                </div>
                <p class="mt-1 text-xs font-bold uppercase tracking-widest text-ink/60">
                    Otoritas Master: Pantau akun dan tegakkan aturan platform KLIKIN
                </p>
            </div>
        </div>
    </x-slot>

    <div x-data="{
        banModalOpen: false,
        selectedUser: null,
        banActionUrl: '',
        openBanModal(user, actionUrl) {
            this.selectedUser = user;
            this.banActionUrl = actionUrl;
            this.banModalOpen = true;
        },
        closeBanModal() {
            this.banModalOpen = false;
            this.selectedUser = null;
            this.banActionUrl = '';
        }
    }" class="space-y-6">

        @if (session('status'))
            <div class="border-4 border-ink bg-pop-lime p-4 font-bold shadow-nb-sm flex items-center justify-between">
                <span>✓ {{ session('status') }}</span>
                <button type="button" onclick="this.parentElement.remove()" class="font-display">✕</button>
            </div>
        @endif

        @if (session('error'))
            <div class="border-4 border-ink bg-pop-red p-4 font-bold shadow-nb-sm flex items-center justify-between">
                <span>✕ {{ session('error') }}</span>
                <button type="button" onclick="this.parentElement.remove()" class="font-display">✕</button>
            </div>
        @endif

        <!-- Stats Overview Cards -->
        <section class="grid gap-4 grid-cols-2 sm:grid-cols-4">
            <div class="nb-card bg-white p-4">
                <p class="text-[11px] font-bold uppercase tracking-widest text-ink/60">Total Pengguna</p>
                <p class="mt-1 font-display text-3xl">{{ $stats['total'] }}</p>
            </div>
            <div class="nb-card bg-pop-purple p-4">
                <p class="text-[11px] font-bold uppercase tracking-widest text-ink/80">Master Admin</p>
                <p class="mt-1 font-display text-3xl">{{ $stats['masters'] }}</p>
            </div>
            <div class="nb-card bg-pop-lime p-4">
                <p class="text-[11px] font-bold uppercase tracking-widest text-ink/80">Akun Aktif</p>
                <p class="mt-1 font-display text-3xl">{{ $stats['active'] }}</p>
            </div>
            <div class="nb-card bg-pop-red p-4">
                <p class="text-[11px] font-bold uppercase tracking-widest text-ink/80">Akun Banned</p>
                <p class="mt-1 font-display text-3xl">{{ $stats['banned'] }}</p>
            </div>
        </section>

        <!-- Filters & Search Form -->
        <section class="nb-card bg-cream p-4 sm:p-5">
            <form method="GET" action="{{ route('admin.users.index') }}" class="grid gap-3 sm:grid-cols-12 items-end">
                <div class="sm:col-span-5">
                    <label class="nb-label" for="search-input">Cari Pengguna</label>
                    <input
                        id="search-input"
                        type="text"
                        name="q"
                        value="{{ $filters['q'] }}"
                        placeholder="Nama, @username, atau email..."
                        class="nb-input"
                    >
                </div>

                <div class="sm:col-span-3">
                    <label class="nb-label" for="filter-role">Filter Role</label>
                    <select id="filter-role" name="role" class="nb-input">
                        <option value="">Semua Role</option>
                        <option value="master" {{ $filters['role'] === 'master' ? 'selected' : '' }}>Master</option>
                        <option value="user" {{ $filters['role'] === 'user' ? 'selected' : '' }}>User</option>
                    </select>
                </div>

                <div class="sm:col-span-2">
                    <label class="nb-label" for="filter-status">Filter Status</label>
                    <select id="filter-status" name="status" class="nb-input">
                        <option value="">Semua Status</option>
                        <option value="active" {{ $filters['status'] === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="banned" {{ $filters['status'] === 'banned' ? 'selected' : '' }}>Banned</option>
                    </select>
                </div>

                <div class="sm:col-span-2 flex gap-2">
                    <button type="submit" class="nb-btn nb-btn-primary flex-1">
                        Cari
                    </button>
                    @if ($filters['q'] || $filters['role'] || $filters['status'])
                        <a href="{{ route('admin.users.index') }}" class="nb-btn nb-btn-ghost px-3" title="Reset filter">
                            ✕
                        </a>
                    @endif
                </div>
            </form>
        </section>

        <!-- Users Table -->
        <section class="nb-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b-4 border-ink bg-pop-yellow text-xs font-bold uppercase tracking-wider">
                        <tr>
                            <th class="p-3 sm:p-4">Pengguna</th>
                            <th class="p-3 sm:p-4">Email</th>
                            <th class="p-3 sm:p-4">Role</th>
                            <th class="p-3 sm:p-4">Statistik</th>
                            <th class="p-3 sm:p-4">Status Akun</th>
                            <th class="p-3 sm:p-4 text-right">Aksi Otoritas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-ink/20 bg-white">
                        @forelse ($users as $user)
                            <tr class="hover:bg-cream/40 transition">
                                <td class="p-3 sm:p-4">
                                    <div class="flex items-center gap-3">
                                        <div class="min-w-0">
    <p class="font-bold text-sm leading-snug {{ $user->id === Auth::id() ? 'text-yellow-600' : ''}} {{ $user->isBanned() ? 'line-through text-ink/60' : '' }}">
        {{ $user->name }}
    </p>
</div>
                                    </div>
                                </td>

                                <td class="p-3 sm:p-4 text-xs font-medium">
                                    {{ $user->email }}
                                </td>

                                <td class="p-3 sm:p-4">
                                    @if ($user->isMaster())
                                        <span class="nb-badge bg-pop-purple text-ink">
                                            MASTER
                                        </span>
                                    @else
                                        <span class="nb-badge bg-white text-ink">
                                            USER
                                        </span>
                                    @endif
                                </td>

                                <td class="p-3 sm:p-4 text-xs font-bold text-ink/70">
                                    <span>{{ $user->categories_count }} Kategori</span> ·
                                    <span>{{ $user->affiliate_products_count }} Produk</span>
                                </td>

                                <td class="p-3 sm:p-4">
                                    @if ($user->isBanned())
                                        <div class="space-y-1">
                                            <span class="nb-badge bg-pop-red text-ink font-bold animate-pulse">
                                                ⛔ BANNED
                                            </span>
                                            <!-- @if ($user->ban_reason)
                                                <p class="text-[11px] font-medium text-ink/70 max-w-xs truncate" title="{{ $user->ban_reason }}">
                                                    "{{ $user->ban_reason }}"
                                                </p>
                                            @endif -->
                                        </div>
                                    @else
                                        <span class="nb-badge bg-pop-lime text-ink">
                                            ✓ AKTIF
                                        </span>
                                    @endif
                                </td>

                                <td class="p-3 sm:p-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a
                                            href="{{ route('profile.show', $user) }}"
                                            target="_blank"
                                            class="nb-btn nb-btn-ghost nb-btn-sm"
                                            title="Buka halaman profil publik"
                                        >
                                            Halaman
                                        </a>

                                        @if ($user->id === Auth::id())
                                            <!-- <span class="text-[11px] font-bold text-ink/40 uppercase">Akun Anda</span> -->
                                        @elseif ($user->isMaster())
                                            <span class="text-[11px] font-bold text-pop-purple uppercase">Master Dilindungi</span>
                                        @elseif ($user->isBanned())
                                            <form method="POST" action="{{ route('admin.users.unban', $user) }}" onsubmit="return confirm('Pulihkan dan aktifkan kembali akun ini?');">
                                                @csrf
                                                <button type="submit" class="nb-btn nb-btn-lime nb-btn-sm">
                                                    ✓ Unban
                                                </button>
                                            </form>
                                        @else
                                            <button
                                                type="button"
                                                @click="openBanModal({
                                                    id: '{{ $user->id }}',
                                                    name: '{{ addslashes($user->name) }}',
                                                    username: '{{ $user->username }}'
                                                }, '{{ route('admin.users.ban', $user) }}')"
                                                class="nb-btn nb-btn-danger nb-btn-sm"
                                            >
                                                ✕ Ban
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center">
                                    <p class="font-display text-lg uppercase">Tidak Ada Data Pengguna</p>
                                    <p class="mt-1 text-xs text-ink/60">Coba ubah kata kunci pencarian atau filter yang digunakan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($users->hasPages())
                <div class="border-t-4 border-ink bg-paper p-4">
                    {{ $users->links() }}
                </div>
            @endif
        </section>

        <!-- Ban User Modal -->
        <div
            x-show="banModalOpen"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-ink/70"
            @keydown.escape.window="closeBanModal()"
        >
            <div
                @click.away="closeBanModal()"
                class="nb-card w-full max-w-md bg-paper p-6 relative border-4 border-ink shadow-nb-lg"
            >
                <div class="border-b-4 border-ink pb-3 mb-4">
                    <span class="nb-badge bg-pop-red text-ink font-bold">Tindakan Otoritas Master</span>
                    <h3 class="mt-2 font-display text-xl uppercase">Ban Pengguna</h3>
                    <p class="text-xs font-bold text-ink/70 mt-1">
                        Menangguhkan akun <span class="text-pop-red underline" x-text="selectedUser?.name"></span> (<span x-text="'@' + selectedUser?.username"></span>)
                    </p>
                </div>

                <div class="border-2 border-dashed border-ink/40 bg-cream p-3 text-xs font-medium text-ink/80 mb-4">
                    ⚠️ Pengguna yang di-ban tidak akan dapat login, produk affiliate dibekukan, dan profil publiknya akan disegel dengan halaman peringatan <strong>DO NOT CROSS</strong>.
                </div>

                <form :action="banActionUrl" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="nb-label" for="ban-reason-input">Alasan Penindakan / Pelanggaran</label>
                            <textarea
                                id="ban-reason-input"
                                name="reason"
                                rows="3"
                                required
                                class="nb-input w-full"
                                placeholder="Contoh: Menyebarkan tautan affiliate penipuan (phising) dan melanggar pedoman komunitas."
                            ></textarea>
                        </div>

                        <div class="flex items-center justify-end gap-2 pt-2 border-t-2 border-ink">
                            <button
                                type="button"
                                @click="closeBanModal()"
                                class="nb-btn nb-btn-ghost nb-btn-sm"
                            >
                                Batal
                            </button>
                            <button
                                type="submit"
                                class="nb-btn nb-btn-danger nb-btn-sm"
                            >
                                Konfirmasi Ban Pengguna
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>

