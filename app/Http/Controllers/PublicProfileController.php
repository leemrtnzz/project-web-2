<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class PublicProfileController extends Controller
{
    public function show(User $user): View
    {
        if ($user->isBanned()) {
            return view('profile.banned', [
                'user' => $user,
            ]);
        }

        $products = $user->affiliateProducts()
            ->with('category')
            ->latest()
            ->get();

        return view('profile.show', [
            'user' => $user,
            'productsByCategory' => $products->groupBy(fn ($product) => $product->category->name),
        ]);
    }
}
