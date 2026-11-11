<?php

use App\Models\User;

test('users can have master or user role and have helper methods', function () {
    $regularUser = User::factory()->create(['role' => 'user']);
    $masterUser = User::factory()->master()->create();

    expect($regularUser->isUser())->toBeTrue()
        ->and($regularUser->isMaster())->toBeFalse()
        ->and($masterUser->isMaster())->toBeTrue()
        ->and($masterUser->isUser())->toBeFalse();
});

test('guests are redirected to login when accessing admin users panel', function () {
    $response = $this->get(route('admin.users.index'));

    $response->assertRedirect(route('login'));
});

test('regular users cannot access admin users panel', function () {
    $user = User::factory()->create(['role' => 'user']);

    $response = $this->actingAs($user)->get(route('admin.users.index'));

    $response->assertForbidden();
});

test('master users can view the admin users panel with user listings', function () {
    $master = User::factory()->master()->create();
    $targetUser = User::factory()->create(['name' => 'Si Fulan', 'role' => 'user']);

    $response = $this->actingAs($master)->get(route('admin.users.index'));

    $response->assertOk()
        ->assertSee('Kelola Pengguna')
        ->assertSee('Master Panel')
        ->assertSee('Si Fulan');
});

test('master users can ban a regular user with a reason', function () {
    $master = User::factory()->master()->create();
    $targetUser = User::factory()->create(['role' => 'user']);

    expect($targetUser->isBanned())->toBeFalse();

    $response = $this->actingAs($master)
        ->from(route('admin.users.index'))
        ->post(route('admin.users.ban', $targetUser), [
            'reason' => 'Melakukan spamming link judi online.',
        ]);

    $response->assertRedirect(route('admin.users.index'))
        ->assertSessionHas('status');

    $targetUser->refresh();

    expect($targetUser->isBanned())->toBeTrue()
        ->and($targetUser->banned_at)->not->toBeNull()
        ->and($targetUser->ban_reason)->toBe('Melakukan spamming link judi online.');
});

test('master users cannot ban themselves', function () {
    $master = User::factory()->master()->create();

    $response = $this->actingAs($master)
        ->from(route('admin.users.index'))
        ->post(route('admin.users.ban', $master), [
            'reason' => 'Ingin ban diri sendiri.',
        ]);

    $response->assertRedirect(route('admin.users.index'))
        ->assertSessionHas('error');

    $master->refresh();
    expect($master->isBanned())->toBeFalse();
});

test('master users cannot ban other master users', function () {
    $master1 = User::factory()->master()->create();
    $master2 = User::factory()->master()->create();

    $response = $this->actingAs($master1)
        ->from(route('admin.users.index'))
        ->post(route('admin.users.ban', $master2), [
            'reason' => 'Mencoba ban sesama master.',
        ]);

    $response->assertRedirect(route('admin.users.index'))
        ->assertSessionHas('error');

    $master2->refresh();
    expect($master2->isBanned())->toBeFalse();
});

test('regular users cannot ban other users', function () {
    $user1 = User::factory()->create(['role' => 'user']);
    $user2 = User::factory()->create(['role' => 'user']);

    $response = $this->actingAs($user1)
        ->post(route('admin.users.ban', $user2), [
            'reason' => 'Mencoba ban ilegal.',
        ]);

    $response->assertForbidden();
    expect($user2->fresh()->isBanned())->toBeFalse();
});

test('master users can unban a banned user', function () {
    $master = User::factory()->master()->create();
    $bannedUser = User::factory()->banned('Pelanggaran sementara')->create();

    expect($bannedUser->isBanned())->toBeTrue();

    $response = $this->actingAs($master)
        ->from(route('admin.users.index'))
        ->post(route('admin.users.unban', $bannedUser));

    $response->assertRedirect(route('admin.users.index'))
        ->assertSessionHas('status');

    $bannedUser->refresh();

    expect($bannedUser->isBanned())->toBeFalse()
        ->and($bannedUser->banned_at)->toBeNull()
        ->and($bannedUser->ban_reason)->toBeNull();
});
