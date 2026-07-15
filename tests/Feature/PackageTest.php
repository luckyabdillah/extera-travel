<?php

use App\Models\Package;
use App\Models\PackageCategory;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('can list packages on the admin panel', function () {
    $category = PackageCategory::create(['name' => 'Test Cat']);
    Package::create([
        'title' => 'Test Package',
        'package_category_id' => $category->id,
        'date' => Carbon::now()->addMonth(),
        'total_days' => 9,
        'quota' => 25,
    ]);

    $response = $this->get(route('admin.packages.index'));

    $response->assertStatus(200);
    $response->assertSee('Test Package');
});

it('can show the create form', function () {
    $response = $this->get(route('admin.packages.create'));

    $response->assertStatus(200);
    $response->assertSee('Tambah Paket Perjalanan');
});

it('can store a new package with prices', function () {
    $category = PackageCategory::create(['name' => 'Cat']);

    $response = $this->post(route('admin.packages.store'), [
        'title' => 'New Package',
        'package_category_id' => $category->id,
        'date' => Carbon::now()->addMonth()->format('Y-m-d'),
        'total_days' => 9,
        'quota' => 30,
        'inclusions' => "Item 1\nItem 2",
        'exclusions' => "Item 3",
        'prices' => [
            ['price_type' => 'Double', 'currency' => 'IDR', 'amount' => 30000000],
            ['price_type' => 'Single', 'currency' => 'USD', 'amount' => 2000],
        ],
    ]);

    $response->assertRedirect(route('admin.packages.index'));
    $this->assertDatabaseHas('packages', [
        'title' => 'New Package',
    ]);

    $package = Package::where('title', 'New Package')->first();
    expect($package->prices)->toHaveCount(2);
});

it('can store a package with flyer image', function () {
    Storage::fake('public');

    $response = $this->post(route('admin.packages.store'), [
        'title' => 'Package With Flyer',
        'date' => Carbon::now()->addMonth()->format('Y-m-d'),
        'total_days' => 9,
        'quota' => 20,
        'flyer_path' => UploadedFile::fake()->image('flyer.jpg'),
    ]);

    $response->assertRedirect(route('admin.packages.index'));
    $package = Package::where('title', 'Package With Flyer')->first();
    expect($package)->not->toBeNull();
    Storage::disk('public')->assertExists($package->flyer_path);
});

it('can show the edit form', function () {
    $package = Package::create([
        'title' => 'Edit Package',
        'date' => Carbon::now()->addMonth(),
        'total_days' => 9,
        'quota' => 15,
    ]);

    $response = $this->get(route('admin.packages.edit', $package));

    $response->assertStatus(200);
    $response->assertSee('Edit Paket Perjalanan');
});

it('can update a package and sync prices', function () {
    $category = PackageCategory::create(['name' => 'Old Cat']);
    $package = Package::create([
        'title' => 'Old Package',
        'package_category_id' => $category->id,
        'date' => Carbon::now()->addMonth(),
        'total_days' => 9,
        'quota' => 10,
    ]);
    $package->prices()->create(['price_type' => 'Double', 'currency' => 'IDR', 'price' => 25000000]);

    $newCategory = PackageCategory::create(['name' => 'New Cat']);

    $response = $this->put(route('admin.packages.update', $package), [
        'title' => 'Updated Package',
        'package_category_id' => $newCategory->id,
        'date' => Carbon::now()->addMonths(2)->format('Y-m-d'),
        'total_days' => 12,
        'quota' => 20,
        'prices' => [
            ['price_type' => 'Single', 'currency' => 'USD', 'amount' => 2200],
        ],
    ]);

    $response->assertRedirect(route('admin.packages.index'));
    $this->assertDatabaseHas('packages', [
        'uuid' => $package->uuid,
        'title' => 'Updated Package',
        'total_days' => 12,
    ]);

    $package->refresh();
    expect($package->prices)->toHaveCount(1);
    expect((float) $package->prices->first()->price)->toBe(2200.0);
});

it('can delete a package and its flyer', function () {
    Storage::fake('public');
    $flyer = UploadedFile::fake()->image('delete-flyer.jpg')->store('packages', 'public');

    $package = Package::create([
        'title' => 'Delete Package',
        'flyer_path' => $flyer,
        'date' => Carbon::now()->addMonth(),
        'total_days' => 9,
        'quota' => 10,
    ]);

    $response = $this->delete(route('admin.packages.destroy', $package));

    $response->assertRedirect(route('admin.packages.index'));
    $this->assertDatabaseMissing('packages', ['id' => $package->id]);
    Storage::disk('public')->assertMissing($flyer);
});

it('auto-generates slug from title', function () {
    $package = Package::create([
        'title' => 'Auto Slug Package',
        'date' => Carbon::now()->addMonth(),
        'total_days' => 9,
        'quota' => 10,
    ]);

    expect($package->slug)->toBe('auto-slug-package');
});
