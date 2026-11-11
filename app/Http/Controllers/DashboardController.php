<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();

        return view('dashboard', [
            'productCount' => $user->affiliateProducts()->count(),
            'categoryCount' => $user->categories()->count(),
            'clickCount' => (int) $user->affiliateProducts()->sum('count'),
            'topProducts' => $user->affiliateProducts()
                ->with('category')
                ->orderByDesc('count')
                ->take(5)
                ->get(),
            'recentProducts' => $user->affiliateProducts()
                ->with('category')
                ->latest()
                ->take(6)
                ->get(),
        ]);
    }
}
