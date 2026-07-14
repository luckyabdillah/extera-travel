<?php

use App\Models\Faq;

it('can list faqs on the admin panel', function () {
    Faq::create([
        'question' => 'Test Question?',
        'answer' => 'Test answer.',
    ]);

    $response = $this->get(route('admin.faqs.index'));

    $response->assertStatus(200);
    $response->assertSee('Test Question?');
});

it('can show the create form', function () {
    $response = $this->get(route('admin.faqs.create'));

    $response->assertStatus(200);
    $response->assertSee('Tambah FAQ');
});

it('can store a new faq', function () {
    $response = $this->post(route('admin.faqs.store'), [
        'question' => 'New Question?',
        'answer' => 'New answer here.',
    ]);

    $response->assertRedirect(route('admin.faqs.index'));
    $this->assertDatabaseHas('faqs', [
        'question' => 'New Question?',
    ]);
});

it('can show the edit form', function () {
    $faq = Faq::create([
        'question' => 'Edit Question?',
        'answer' => 'Edit answer.',
    ]);

    $response = $this->get(route('admin.faqs.edit', $faq));

    $response->assertStatus(200);
    $response->assertSee('Edit Question?');
});

it('can update a faq', function () {
    $faq = Faq::create([
        'question' => 'Old Question?',
        'answer' => 'Old answer.',
    ]);

    $response = $this->put(route('admin.faqs.update', $faq), [
        'question' => 'Updated Question?',
        'answer' => 'Updated answer.',
    ]);

    $response->assertRedirect(route('admin.faqs.index'));
    $this->assertDatabaseHas('faqs', [
        'uuid' => $faq->uuid,
        'question' => 'Updated Question?',
    ]);
});

it('can delete a faq', function () {
    $faq = Faq::create([
        'question' => 'Delete Question?',
        'answer' => 'Delete answer.',
    ]);

    $response = $this->delete(route('admin.faqs.destroy', $faq));

    $response->assertRedirect(route('admin.faqs.index'));
    $this->assertDatabaseMissing('faqs', [
        'uuid' => $faq->uuid,
    ]);
});

it('shows faqs on the public FAQ page', function () {
    Faq::create([
        'question' => 'Public Question?',
        'answer' => 'Public answer.',
    ]);

    $response = $this->get('/faq');

    $response->assertStatus(200);
    $response->assertSee('Public Question?');
    $response->assertSee('Pertanyaan yang Sering Diajukan');
});
