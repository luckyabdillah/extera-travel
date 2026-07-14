<?php

use App\Models\HeroImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('can list hero images on the admin panel', function () {
    $hero = HeroImage::create([
        'title' => 'Test Image',
        'path' => 'hero-images/test.jpg',
    ]);

    $response = $this->get(route('admin.hero-images.index'));

    $response->assertStatus(200);
    $response->assertSee('Test Image');
});

it('can show the create form', function () {
    $response = $this->get(route('admin.hero-images.create'));

    $response->assertStatus(200);
    $response->assertSee('Tambah Hero Image');
});

it('can store a new hero image', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->image('hero.jpg');

    $response = $this->post(route('admin.hero-images.store'), [
        'title' => 'New Hero Title',
        'image' => $file,
    ]);

    $response->assertRedirect(route('admin.hero-images.index'));
    $this->assertDatabaseHas('hero_images', [
        'title' => 'New Hero Title',
    ]);

    $hero = HeroImage::first();
    Storage::disk('public')->assertExists($hero->path);
});

it('can show the edit form', function () {
    $hero = HeroImage::create([
        'title' => 'Edit Title',
        'path' => 'hero-images/test.jpg',
    ]);

    $response = $this->get(route('admin.hero-images.edit', $hero));

    $response->assertStatus(200);
    $response->assertSee('Edit Title');
});

it('can update a hero image', function () {
    Storage::fake('public');
    $oldFile = UploadedFile::fake()->image('old.jpg');
    $oldPath = $oldFile->store('hero-images', 'public');

    $hero = HeroImage::create([
        'title' => 'Old Title',
        'path' => $oldPath,
    ]);

    $newFile = UploadedFile::fake()->image('new.jpg');

    $response = $this->put(route('admin.hero-images.update', $hero), [
        'title' => 'Updated Title',
        'image' => $newFile,
    ]);

    $response->assertRedirect(route('admin.hero-images.index'));
    $this->assertDatabaseHas('hero_images', [
        'uuid' => $hero->uuid,
        'title' => 'Updated Title',
    ]);

    $hero->refresh();
    Storage::disk('public')->assertExists($hero->path);
    Storage::disk('public')->assertMissing($oldPath);
});

it('can delete a hero image', function () {
    Storage::fake('public');
    $file = UploadedFile::fake()->image('test.jpg');
    $path = $file->store('hero-images', 'public');

    $hero = HeroImage::create([
        'title' => 'Delete Title',
        'path' => $path,
    ]);

    $response = $this->delete(route('admin.hero-images.destroy', $hero));

    $response->assertRedirect(route('admin.hero-images.index'));
    $this->assertDatabaseMissing('hero_images', [
        'uuid' => $hero->uuid,
    ]);
    Storage::disk('public')->assertMissing($path);
});
