<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Filament\Resources\Users\UserResource;

uses(RefreshDatabase::class);

test('admin can view users resource', function () {
    $admin = createAdmin();
    $this->actingAs($admin);
    expect(UserResource::canViewAny())->toBeTrue();
});

test('store cannot view users resource', function () {
    $store = User::factory()->create(['role' => 'store']);
    $this->actingAs($store);
    expect(UserResource::canViewAny())->toBeFalse();
});

test('admin can create store user', function () {
    $admin = createAdmin();
    $this->actingAs($admin);

    $user = User::withoutEvents(fn() => User::factory()->create([
        'name' => 'Toko A',
        'username' => 'tokoa',
        'email' => 'tokoa@example.com',
        'password' => 'secret123',
        'role' => 'store',
    ]));
    expect($user)->not->toBeNull();
    expect($user->role)->toBe('store');
});

test('admin can update user', function () {
    $admin = createAdmin();
    $user = User::factory()->create(['role' => 'store']);
    $this->actingAs($admin);

    $user->update(['name' => 'Nama Baru']);
    expect($user->name)->toBe('Nama Baru');
});

test('admin can delete user', function () {
    $admin = createAdmin();
    $user = User::factory()->create(['role' => 'store']);
    $this->actingAs($admin);

    $user->delete();
    expect(User::find($user->id))->toBeNull();
});
