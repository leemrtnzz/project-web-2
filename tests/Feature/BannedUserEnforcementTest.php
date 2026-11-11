<?php

use App\Models\User;

test('banned user cannot log in and sees violation reason', function () {
    $bannedUser = User::factory()->banned('Menyebarkan malware melalui link affiliate')->create([
        'email' => 'terban@example.com',
        'password' => bcrypt('password123'),
    ]);

    $response = $this->post(route('login'), [
        'email' => 'terban@example.com',
        'password' => 'password123',
    ]);

    $this->assertGuest();
    $response->assertSessionHasErrors('email');
    $response->assertSessionHasErrors([
        'email' => 'Akun Anda telah di-banned karena melanggar aturan: Menyebarkan malware melalui link affiliate',
    ]);
});

test('public profile of a banned user renders DO NOT CROSS notice and conceals affiliate products', function () {
    $bannedUser = User::factory()->banned('Penipuan hadiah palsu')->create([
        'name' => 'Si Spammer',
        'username' => 'sispammer',
    ]);

    $category = $bannedUser->categories()->create([
        'name' => 'Promo Palsu',
    ]);

    $bannedUser->affiliateProducts()->create([
        'category_id' => $category->id,
        'title' => 'Produk Haram Banned',
        'affiliate_url' => 'https://evil.example.com',
    ]);

    $response = $this->get(route('profile.show', $bannedUser));

    $response->assertOk()
        ->assertSee('DO NOT CROSS', false)
        ->assertSee('POLICE LINE', false)
        ->assertSee('AKUN DITANGGUHKAN', false)
        ->assertSee('Penipuan hadiah palsu')
        ->assertDontSee('Produk Haram Banned');
});

test('public profile of an active user displays products normally', function () {
    $activeUser = User::factory()->create([
        'name' => 'Creator Baik',
        'username' => 'creatorbaik',
    ]);

    $category = $activeUser->categories()->create([
        'name' => 'Gadget Unggulan',
    ]);

    $activeUser->affiliateProducts()->create([
        'category_id' => $category->id,
        'title' => 'Keyboard Mekanikal Keren',
        'affiliate_url' => 'https://shopee.co.id/keyboard',
    ]);

    $response = $this->get(route('profile.show', $activeUser));

    $response->assertOk()
        ->assertSee('Creator Baik')
        ->assertSee('Keyboard Mekanikal Keren')
        ->assertDontSee('DO NOT CROSS');
});

test('affiliate link redirect is blocked if user is banned', function () {
    $bannedUser = User::factory()->banned('Pelanggaran link affiliate berbahaya')->create();

    $category = $bannedUser->categories()->create([
        'name' => 'Kategori Gelap',
    ]);

    $product = $bannedUser->affiliateProducts()->create([
        'category_id' => $category->id,
        'title' => 'Produk Bahaya',
        'affiliate_url' => 'https://evil.example.com/dangerous-link',
    ]);

    $response = $this->get(route('products.redirect', $product));

    $response->assertForbidden();
});

test('affiliate link redirect succeeds if user is active', function () {
    $activeUser = User::factory()->create();

    $category = $activeUser->categories()->create([
        'name' => 'Elektronik',
    ]);

    $product = $activeUser->affiliateProducts()->create([
        'category_id' => $category->id,
        'title' => 'Headset Bluetooth',
        'affiliate_url' => 'https://example.com/legit-product',
    ]);

    $response = $this->get(route('products.redirect', $product));

    $response->assertRedirect('https://example.com/legit-product');
    expect($product->fresh()->count)->toBe(1);
});

test('logged in user is logged out by middleware if banned', function () {
    $user = User::factory()->create();

    // Verify accessible when active
    $this->actingAs($user)->get(route('dashboard'))->assertOk();

    // Now ban the user
    $user->ban('Pelanggaran mendadak');

    // Accessing dashboard should kick user out to login
    $response = $this->actingAs($user)->get(route('dashboard'));

    $response->assertRedirect(route('login'))
        ->assertSessionHasErrors('email');

    $this->assertGuest();
});
