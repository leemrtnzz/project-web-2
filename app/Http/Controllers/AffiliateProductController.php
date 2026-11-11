<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAffiliateProductRequest;
use App\Http\Requests\UpdateAffiliateProductRequest;
use App\Models\AffiliateProduct;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AffiliateProductController extends Controller
{
    public function index(Request $request): View
    {
        return view('products.index', [
            'products' => $request->user()
                ->affiliateProducts()
                ->with('category')
                ->latest()
                ->paginate(9),
        ]);
    }

    public function create(Request $request): View
    {
        return view('products.create', [
            'categories' => $request->user()->categories()->orderBy('name')->get(),
        ]);
    }

    public function store(StoreAffiliateProductRequest $request): RedirectResponse
    {
        $request->user()->affiliateProducts()->create($request->validated());

        return redirect()
            ->route('products.index')
            ->with('status', 'Produk berhasil ditambahkan.');
    }

    public function edit(Request $request, AffiliateProduct $product): View
    {
        $this->ensureOwnedByUser($request, $product);

        return view('products.edit', [
            'product' => $product,
            'categories' => $request->user()->categories()->orderBy('name')->get(),
        ]);
    }

    public function update(UpdateAffiliateProductRequest $request, AffiliateProduct $product): RedirectResponse
    {
        $this->ensureOwnedByUser($request, $product);

        $product->update($request->validated());

        return redirect()
            ->route('products.index')
            ->with('status', 'Produk berhasil diperbarui.');
    }

    public function destroy(Request $request, AffiliateProduct $product): RedirectResponse
    {
        $this->ensureOwnedByUser($request, $product);

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('status', 'Produk berhasil dihapus.');
    }

    public function redirect(AffiliateProduct $affiliateProduct): RedirectResponse
    {
        if ($affiliateProduct->user->isBanned()) {
            abort(403, 'Produk affiliate ini tidak dapat diakses karena akun pemilik telah ditangguhkan.');
        }

        $affiliateProduct->increment('count');

        return redirect()->away($affiliateProduct->affiliate_url);
    }

    private function ensureOwnedByUser(Request $request, AffiliateProduct $product): void
    {
        abort_unless($product->user_id === $request->user()->id, 403);
    }
}
