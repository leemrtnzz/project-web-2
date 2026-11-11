<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::query()
            ->withCount(['categories', 'affiliateProducts'])
            ->latest();

        if ($search = $request->string('q')->trim()->value()) {
            $query->where(function ($q) use ($search): void {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($role = $request->string('role')->trim()->value()) {
            if (in_array($role, ['master', 'user'], true)) {
                $query->where('role', $role);
            }
        }

        if ($status = $request->string('status')->trim()->value()) {
            if ($status === 'active') {
                $query->where('is_banned', false);
            } elseif ($status === 'banned') {
                $query->where('is_banned', true);
            }
        }

        $users = $query->paginate(10)->withQueryString();

        $stats = [
            'total' => User::count(),
            'masters' => User::where('role', 'master')->count(),
            'active' => User::where('is_banned', false)->count(),
            'banned' => User::where('is_banned', true)->count(),
        ];

        return view('admin.users.index', [
            'users' => $users,
            'stats' => $stats,
            'filters' => [
                'q' => $request->input('q', ''),
                'role' => $request->input('role', ''),
                'status' => $request->input('status', ''),
            ],
        ]);
    }

    public function ban(Request $request, User $user): RedirectResponse
    {
        if ($user->id === $request->user()->id) {
            return back()->with('error', 'Anda tidak dapat mem-ban akun Anda sendiri.');
        }

        if ($user->isMaster()) {
            return back()->with('error', 'Pengguna dengan role Master tidak dapat di-ban.');
        }

        $validated = $request->validate([
            'reason' => ['nullable', 'string', 'max:500'],
        ]);

        $reason = $validated['reason'] ?? 'Melanggar aturan dan pedoman komunitas KLIKIN.';

        $user->ban($reason);

        return back()->with('status', "Pengguna {$user->name} (@{$user->username}) berhasil di-ban.");
    }

    public function unban(Request $request, User $user): RedirectResponse
    {
        if (! $user->isBanned()) {
            return back()->with('info', "Pengguna {$user->name} tidak dalam status banned.");
        }

        $user->unban();

        return back()->with('status', "Pengguna {$user->name} (@{$user->username}) berhasil dipulihkan (unban).");
    }
}
