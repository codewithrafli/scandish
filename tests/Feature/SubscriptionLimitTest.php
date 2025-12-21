<?php

use App\Filament\Resources\Products\ProductResource;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function seedStoreWithOneProduct(): array
{
    $store = User::factory()->create(['role' => 'store']);
    test()->actingAs($store);
    $category = ProductCategory::create([
        'name' => 'Makanan',
        'icon' => 'icons/makanan.png',
    ]);
    Product::create([
        'product_category_id' => $category->id,
        'image' => 'images/menu.jpg',
        'name' => 'Satu Produk',
        'description' => 'desc',
        'price' => 10000,
        'rating' => 5,
        'is_popular' => false,
    ]);
    return [$store, $category];
}

test('store without active subscription cannot access product create when limit reached', function () {
    [$store] = seedStoreWithOneProduct();
    $this->actingAs($store);
    expect(ProductResource::canCreate())->toBeFalse();
});

test('store with active subscription can access product create despite limit', function () {
    [$store] = seedStoreWithOneProduct();
    $this->actingAs($store);
    Subscription::create(['is_active' => true]);
    expect(ProductResource::canCreate())->toBeTrue();
});
