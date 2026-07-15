<?php

use App\Models\Blog;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('can list blogs on the admin panel', function () {
    Blog::create([
        'title' => 'Test Blog',
        'slug' => 'test-blog',
        'content' => 'Test content',
    ]);

    $response = $this->get(route('admin.blogs.index'));

    $response->assertStatus(200);
    $response->assertSee('Test Blog');
});

it('can show the create form', function () {
    $response = $this->get(route('admin.blogs.create'));

    $response->assertStatus(200);
    $response->assertSee('Tulis Artikel Baru');
});

it('can store a new blog and auto-generate slug', function () {
    $response = $this->post(route('admin.blogs.store'), [
        'title' => 'My New Blog Post',
        'content' => '<p>New blog content</p>',
    ]);

    $response->assertRedirect(route('admin.blogs.index'));
    $this->assertDatabaseHas('blogs', [
        'title' => 'My New Blog Post',
        'slug' => 'my-new-blog-post',
    ]);
});

it('can upload blog images for quill', function () {
    Storage::fake('public');

    $response = $this->postJson(route('admin.blogs.upload-image'), [
        'image' => UploadedFile::fake()->image('content.jpg'),
    ]);

    $response->assertOk()->assertJsonStructure(['url']);
    expect($response->json('url'))->toContain('/storage/blog-images/');
    expect(Storage::disk('public')->allFiles('blog-images'))->toHaveCount(1);
});

it('can show the edit form', function () {
    $blog = Blog::create([
        'title' => 'Edit Blog',
        'slug' => 'edit-blog',
        'content' => 'Edit content',
    ]);

    $response = $this->get(route('admin.blogs.edit', $blog));

    $response->assertStatus(200);
    $response->assertSee('Edit Artikel');
});

it('can update a blog and its slug', function () {
    $blog = Blog::create([
        'title' => 'Old Blog',
        'slug' => 'old-blog',
        'content' => 'Old content',
    ]);

    $response = $this->put(route('admin.blogs.update', $blog), [
        'title' => 'Updated Blog',
        'content' => '<p>Updated content</p>',
    ]);

    $response->assertRedirect(route('admin.blogs.index'));
    $this->assertDatabaseHas('blogs', [
        'id' => $blog->id,
        'title' => 'Updated Blog',
        'slug' => 'updated-blog',
    ]);
});

it('can delete a blog', function () {
    $blog = Blog::create([
        'title' => 'Delete Blog',
        'slug' => 'delete-blog',
        'content' => 'Delete content',
    ]);

    $response = $this->delete(route('admin.blogs.destroy', $blog));

    $response->assertRedirect(route('admin.blogs.index'));
    $this->assertDatabaseMissing('blogs', [
        'id' => $blog->id,
    ]);
});

it('shows blogs on the public index page', function () {
    Blog::create([
        'title' => 'Public Blog List',
        'slug' => 'public-blog-list',
        'content' => 'Content list',
    ]);

    $response = $this->get('/blogs');

    $response->assertStatus(200);
    $response->assertSee('Public Blog List');
});

it('shows a specific blog post', function () {
    $blog = Blog::create([
        'title' => 'Specific Blog',
        'slug' => 'specific-blog',
        'content' => 'Specific content inside.',
    ]);

    $response = $this->get('/blogs/specific-blog');

    $response->assertStatus(200);
    $response->assertSee('Specific Blog');
    $response->assertSee('Specific content inside.');
});
