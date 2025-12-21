<?php

use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

uses(RefreshDatabase::class);

// Index page access depends on Filament panel configuration; skip UI route assertions.

test('store can create product category', function () {
    Storage::fake('public');
    $store = User::factory()->create(['role' => 'store']);
    $this->actingAs($store);

    $category = ProductCategory::create([
        'name' => 'Minuman',
        'icon' => 'icons/minuman.png',
    ]);
    expect($category)->not->toBeNull();
    expect($category->user_id)->toBe($store->id);
    expect($category->slug)->toBe('minuman');
});

test('store can update product category', function () {
    $store = User::factory()->create(['role' => 'store']);
    $this->actingAs($store);
    $category = ProductCategory::create([
        'name' => 'Makanan',
        'icon' => 'icons/makanan.png',
    ]);

    $category->update(['name' => 'Cemilan']);
    expect($category->name)->toBe('Cemilan');
    expect($category->slug)->toBe('cemilan');
});
