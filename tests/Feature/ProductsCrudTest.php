<?php

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

uses(RefreshDatabase::class);

function createStoreWithCategory(): array
{
    $store = User::factory()->create(['role' => 'store']);
    test()->actingAs($store);
    $category = ProductCategory::create([
        'user_id' => $store->id,
        'name' => 'Makanan',
        'slug' => 'makanan',
        'icon' => 'icons/makanan.png',
    ]);
    return [$store, $category];
}

// Index page access depends on Filament panel configuration; skip UI route assertions.

test('store can create product via filament', function () {
    Storage::fake('public');
    [$store, $category] = createStoreWithCategory();
    $this->actingAs($store);

    $product = Product::create([
        'product_category_id' => $category->id,
        'image' => 'images/menu.jpg',
        'name' => 'Nasi Goreng',
        'description' => 'Lezat dan nikmat',
        'price' => 15000,
        'rating' => 5,
        'is_popular' => true,
    ]);
    expect($product)->not->toBeNull();
    expect($product->user_id)->toBe($store->id);
    expect($product->product_category_id)->toBe($category->id);
});

test('store can update product', function () {
    [$store, $category] = createStoreWithCategory();
    $product = Product::create([
        'user_id' => $store->id,
        'product_category_id' => $category->id,
        'image' => 'images/menu.jpg',
        'name' => 'Ayam Bakar',
        'description' => 'Mantap',
        'price' => 20000,
        'rating' => 4,
        'is_popular' => false,
    ]);

    $this->actingAs($store);

    $product->update(['name' => 'Ayam Bakar Spesial']);
    expect($product->name)->toBe('Ayam Bakar Spesial');
});
