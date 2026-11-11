<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        return view('categories.index', [
            'categories' => $request->user()
                ->categories()
                ->withCount('affiliateProducts')
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $request->user()->categories()->create($request->validated());

        return redirect()
            ->route('categories.index')
            ->with('status', 'Kategori berhasil ditambahkan.');
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $this->ensureOwnedByUser($request, $category);

        $category->update($request->validated());

        return redirect()
            ->route('categories.index')
            ->with('status', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Request $request, Category $category): RedirectResponse
    {
        $this->ensureOwnedByUser($request, $category);

        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('status', 'Kategori berhasil dihapus.');
    }

    private function ensureOwnedByUser(Request $request, Category $category): void
    {
        abort_unless($category->user_id === $request->user()->id, 403);
    }
}
