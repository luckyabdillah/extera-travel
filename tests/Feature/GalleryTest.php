<?php

use App\Models\Gallery;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('can list galleries on the admin panel', function () {
    $gallery = Gallery::create([
        'title' => 'Test Gallery',
        'path' => 'galleries/test.jpg',
    ]);

    $response = $this->get(route('admin.galleries.index'));

    $response->assertStatus(200);
    $response->assertSee('Test Gallery');
});

it('can show the create form', function () {
    $response = $this->get(route('admin.galleries.create'));

    $response->assertStatus(200);
    $response->assertSee('Tambah Foto Galeri');
});

it('can store a new gallery', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->image('gallery.jpg');

    $response = $this->post(route('admin.galleries.store'), [
        'title' => 'New Gallery Title',
        'description' => 'A nice description',
        'image' => $file,
    ]);

    $response->assertRedirect(route('admin.galleries.index'));
    $this->assertDatabaseHas('galleries', [
        'title' => 'New Gallery Title',
    ]);

    $gallery = Gallery::first();
    Storage::disk('public')->assertExists($gallery->path);
});

it('can show the edit form', function () {
    $gallery = Gallery::create([
        'title' => 'Edit Title',
        'path' => 'galleries/test.jpg',
    ]);

    $response = $this->get(route('admin.galleries.edit', $gallery));

    $response->assertStatus(200);
    $response->assertSee('Edit Title');
});

it('can update a gallery', function () {
    Storage::fake('public');
    $oldFile = UploadedFile::fake()->image('old.jpg');
    $oldPath = $oldFile->store('galleries', 'public');

    $gallery = Gallery::create([
        'title' => 'Old Title',
        'path' => $oldPath,
    ]);

    $newFile = UploadedFile::fake()->image('new.jpg');

    $response = $this->put(route('admin.galleries.update', $gallery), [
        'title' => 'Updated Title',
        'description' => 'Updated description',
        'image' => $newFile,
    ]);

    $response->assertRedirect(route('admin.galleries.index'));
    $this->assertDatabaseHas('galleries', [
        'uuid' => $gallery->uuid,
        'title' => 'Updated Title',
    ]);

    $gallery->refresh();
    Storage::disk('public')->assertExists($gallery->path);
    Storage::disk('public')->assertMissing($oldPath);
});

it('can delete a gallery', function () {
    Storage::fake('public');
    $file = UploadedFile::fake()->image('test.jpg');
    $path = $file->store('galleries', 'public');

    $gallery = Gallery::create([
        'title' => 'Delete Title',
        'path' => $path,
    ]);

    $response = $this->delete(route('admin.galleries.destroy', $gallery));

    $response->assertRedirect(route('admin.galleries.index'));
    $this->assertDatabaseMissing('galleries', [
        'uuid' => $gallery->uuid,
    ]);
    Storage::disk('public')->assertMissing($path);
});
