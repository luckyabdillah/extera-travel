<?php

use App\Models\Package;
use App\Models\Customer;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

beforeEach(function () {
    Mail::fake();
});

it('can show checkout form', function () {
    $package = Package::create([
        'title' => 'Checkout Package',
        'date' => Carbon::now()->addMonth(),
        'total_days' => 9,
        'quota' => 10,
    ]);

    $response = $this->get(route('checkout', $package));

    $response->assertStatus(200);
    $response->assertSee('Lengkapi Data Pemesan');
});

it('can store customers and show confirmation', function () {
    $package = Package::create([
        'title' => 'Confirm Package',
        'date' => Carbon::now()->addMonth(),
        'total_days' => 9,
        'quota' => 10,
    ]);

    $response = $this->post(route('checkout.customers', $package), [
        'booker_name' => 'John Doe',
        'booker_email' => 'john@example.com',
        'booker_phone' => '08123456789',
        'total_pax' => 2,
        'passengers' => [
            ['name' => 'John Doe', 'email' => 'john@example.com', 'phone' => '08123456789', 'gender' => 'male'],
            ['name' => 'Jane Doe', 'email' => 'jane@example.com', 'phone' => '08123456788', 'gender' => 'female'],
        ],
    ]);

    $response->assertStatus(200);
    $response->assertSee('Konfirmasi Pemesanan');
    $response->assertSee('John Doe');

    $this->assertDatabaseHas('customers', ['name' => 'Jane Doe']);
    expect(session('checkout'))->not->toBeNull();
});

it('can complete checkout and send email', function () {
    $package = Package::create([
        'title' => 'Complete Package',
        'date' => Carbon::now()->addMonth(),
        'total_days' => 9,
        'quota' => 10,
    ]);

    // Create customers via the first step
    $this->post(route('checkout.customers', $package), [
        'booker_name' => 'Alice',
        'booker_email' => 'alice@example.com',
        'booker_phone' => '08123456780',
        'total_pax' => 1,
        'passengers' => [
            ['name' => 'Alice', 'email' => 'alice@example.com', 'phone' => '08123456780', 'gender' => 'female'],
        ],
    ]);

    $response = $this->post(route('checkout.confirm', $package));

    $response->assertRedirect();
    $transaction = Transaction::first();
    expect($transaction)->not->toBeNull();
    expect($transaction->name)->toBe('Alice');
    expect($transaction->details)->toHaveCount(1);
});
