<?php

use App\Models\PackageCategory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('can list package categories on the admin panel', function () {
    PackageCategory::create([
        'name' => 'Test Category',
    ]);

    $response = $this->get(route('admin.package-categories.index'));

    $response->assertStatus(200);
    $response->assertSee('Test Category');
});

it('can show the create form', function () {
    $response = $this->get(route('admin.package-categories.create'));

    $response->assertStatus(200);
    $response->assertSee('Tambah Kategori Paket');
});

it('can store a new package category', function () {
    $response = $this->post(route('admin.package-categories.store'), [
        'name' => 'New Category',
        'mark_as_favorite' => true,
    ]);

    $response->assertRedirect(route('admin.package-categories.index'));
    $this->assertDatabaseHas('package_categories', [
        'name' => 'New Category',
        'mark_as_favorite' => true,
    ]);
});

it('can store a package category with cover image', function () {
    Storage::fake('public');

    $response = $this->post(route('admin.package-categories.store'), [
        'name' => 'Category With Cover',
        'image_cover' => UploadedFile::fake()->image('cover.jpg'),
    ]);

    $response->assertRedirect(route('admin.package-categories.index'));
    $category = PackageCategory::where('name', 'Category With Cover')->first();
    expect($category)->not->toBeNull();
    Storage::disk('public')->assertExists($category->image_cover);
});

it('can show the edit form', function () {
    $category = PackageCategory::create([
        'name' => 'Edit Category',
    ]);

    $response = $this->get(route('admin.package-categories.edit', $category));

    $response->assertStatus(200);
    $response->assertSee('Edit Kategori Paket');
});

it('can update a package category', function () {
    $category = PackageCategory::create([
        'name' => 'Old Name',
    ]);

    $response = $this->put(route('admin.package-categories.update', $category), [
        'name' => 'Updated Name',
        'mark_as_favorite' => true,
    ]);

    $response->assertRedirect(route('admin.package-categories.index'));
    $this->assertDatabaseHas('package_categories', [
        'uuid' => $category->uuid,
        'name' => 'Updated Name',
        'mark_as_favorite' => true,
    ]);
});

it('can soft-delete a package category', function () {
    $category = PackageCategory::create([
        'name' => 'Delete Category',
    ]);

    $response = $this->delete(route('admin.package-categories.destroy', $category));

    $response->assertRedirect(route('admin.package-categories.index'));
    $this->assertSoftDeleted($category);
});

it('can restore a soft-deleted package category', function () {
    $category = PackageCategory::create([
        'name' => 'Restore Category',
    ]);
    $category->delete();

    $response = $this->get(route('admin.package-categories.restore', $category->uuid));

    $response->assertRedirect(route('admin.package-categories.index'));
    $this->assertNotSoftDeleted($category);
});

it('deletes cover image when package category is soft-deleted', function () {
    Storage::fake('public');

    $category = PackageCategory::create([
        'name' => 'Category With Image',
        'image_cover' => UploadedFile::fake()->image('cover.jpg')->store('package-categories', 'public'),
    ]);

    $response = $this->delete(route('admin.package-categories.destroy', $category));

    $response->assertRedirect(route('admin.package-categories.index'));
    Storage::disk('public')->assertMissing($category->image_cover);
});
