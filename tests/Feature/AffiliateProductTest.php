<?php

use App\Models\AffiliateProduct;
use App\Models\Category;
use App\Models\User;

test('authenticated pages render', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $this->get('/dashboard')->assertOk();
    $this->get('/categories')->assertOk();
    $this->get('/products')->assertOk();
    $this->get('/products/create')->assertOk();
    $this->get('/profile')->assertOk();
});

test('public profile page displays products grouped by category', function () {
    $user = User::factory()->create(['username' => 'creator']);
    $category = $user->categories()->create(['name' => 'Gadget']);

    $user->affiliateProducts()->create([
        'category_id' => $category->id,
        'title' => 'Produk Keren',
        'image' => null,
        'affiliate_url' => 'https://example.com/aff',
    ]);

    $this->get('/u/creator')
        ->assertOk()
        ->assertSee('Gadget')
        ->assertSee('Produk Keren');
});

test('affiliate redirect increments click count', function () {
    $user = User::factory()->create();
    $category = $user->categories()->create(['name' => 'Gadget']);

    $product = $user->affiliateProducts()->create([
        'category_id' => $category->id,
        'title' => 'Produk Keren',
        'image' => null,
        'affiliate_url' => 'https://example.com/aff',
    ]);

    $this->get(route('products.redirect', $product))
        ->assertRedirect('https://example.com/aff');

    expect($product->fresh()->count)->toBe(1);
});

test('user can create a category', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('categories.store'), ['name' => 'Kecantikan'])
        ->assertRedirect(route('categories.index'));

    expect($user->categories()->pluck('name')->all())->toBe(['Kecantikan']);
});

test('user cannot update a category owned by someone else', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();

    $category = $owner->categories()->create(['name' => 'Gadget']);

    $this->actingAs($other)
        ->patch(route('categories.update', $category), ['name' => 'Diubah'])
        ->assertForbidden();

    expect($category->fresh()->name)->toBe('Gadget');
});

test('user can create a product in their own category', function () {
    $user = User::factory()->create();
    $category = $user->categories()->create(['name' => 'Gadget']);

    $this->actingAs($user)
        ->post(route('products.store'), [
            'category_id' => $category->id,
            'title' => 'TWS Pro',
            'image' => 'https://example.com/tws.jpg',
            'affiliate_url' => 'https://shopee.co.id/tws',
        ])
        ->assertRedirect(route('products.index'));

    expect($user->affiliateProducts()->count())->toBe(1);
});

test('product cannot be created with another users category', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();

    $category = $other->categories()->create(['name' => 'Gadget']);

    $this->actingAs($user)
        ->post(route('products.store'), [
            'category_id' => $category->id,
            'title' => 'TWS Pro',
            'affiliate_url' => 'https://shopee.co.id/tws',
        ])
        ->assertSessionHasErrors('category_id');

    expect($user->affiliateProducts()->count())->toBe(0);
});

test('user cannot delete a product owned by someone else', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();

    $category = $owner->categories()->create(['name' => 'Gadget']);
    $product = $owner->affiliateProducts()->create([
        'category_id' => $category->id,
        'title' => 'Produk Keren',
        'image' => null,
        'affiliate_url' => 'https://example.com/aff',
    ]);

    $this->actingAs($other)
        ->delete(route('products.destroy', $product))
        ->assertForbidden();

    expect(AffiliateProduct::find($product->id))->not->toBeNull();
    expect(Category::find($category->id))->not->toBeNull();
});
