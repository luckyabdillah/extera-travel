<?php

use App\Models\Package;
use App\Models\PackageItinerary;
use Carbon\Carbon;

it('can list itineraries for a package', function () {
    $package = Package::create([
        'title' => 'Test Package',
        'date' => Carbon::now()->addMonth(),
        'total_days' => 9,
        'quota' => 20,
    ]);
    $package->itineraries()->create([
        'marker' => 'HARI-1',
        'title' => 'Arrival',
        'itinerary' => 'Arrive in Jeddah',
    ]);

    $response = $this->get(route('admin.packages.itineraries.index', $package));

    $response->assertStatus(200);
    $response->assertSee('HARI-1');
});

it('can show the create form', function () {
    $package = Package::create([
        'title' => 'Test Package',
        'date' => Carbon::now()->addMonth(),
        'total_days' => 9,
        'quota' => 20,
    ]);

    $response = $this->get(route('admin.packages.itineraries.create', $package));

    $response->assertStatus(200);
    $response->assertSee('Tambah Itinerary');
});

it('can store an itinerary', function () {
    $package = Package::create([
        'title' => 'Store Package',
        'date' => Carbon::now()->addMonth(),
        'total_days' => 9,
        'quota' => 20,
    ]);

    $response = $this->post(route('admin.packages.itineraries.store', $package), [
        'marker' => 'HARI-2',
        'title' => 'Second Day',
        'itinerary' => 'Full day activities',
        'accommodation_place' => 'Hotel Makkah',
        'meals' => 'Breakfast, Dinner',
    ]);

    $response->assertRedirect(route('admin.packages.itineraries.index', $package));
    $this->assertDatabaseHas('package_itineraries', [
        'marker' => 'HARI-2',
        'title' => 'Second Day',
    ]);
});

it('can show the edit form', function () {
    $package = Package::create([
        'title' => 'Edit Pkg',
        'date' => Carbon::now()->addMonth(),
        'total_days' => 9,
        'quota' => 20,
    ]);
    $itinerary = $package->itineraries()->create([
        'marker' => 'HARI-3',
        'title' => 'Third Day',
        'itinerary' => 'Activities',
    ]);

    $response = $this->get(route('admin.packages.itineraries.edit', [$package, $itinerary]));

    $response->assertStatus(200);
    $response->assertSee('Edit Itinerary');
});

it('can update an itinerary', function () {
    $package = Package::create([
        'title' => 'Update Pkg',
        'date' => Carbon::now()->addMonth(),
        'total_days' => 9,
        'quota' => 20,
    ]);
    $itinerary = $package->itineraries()->create([
        'marker' => 'HARI-4',
        'title' => 'Old Title',
        'itinerary' => 'Old itinerary',
    ]);

    $response = $this->put(route('admin.packages.itineraries.update', [$package, $itinerary]), [
        'marker' => 'HARI-4',
        'title' => 'Updated Title',
        'itinerary' => 'Updated itinerary',
    ]);

    $response->assertRedirect(route('admin.packages.itineraries.index', $package));
    $this->assertDatabaseHas('package_itineraries', [
        'id' => $itinerary->id,
        'title' => 'Updated Title',
    ]);
});

it('can delete an itinerary', function () {
    $package = Package::create([
        'title' => 'Delete Pkg',
        'date' => Carbon::now()->addMonth(),
        'total_days' => 9,
        'quota' => 20,
    ]);
    $itinerary = $package->itineraries()->create([
        'marker' => 'HARI-5',
        'title' => 'Delete Day',
        'itinerary' => 'To be deleted',
    ]);

    $response = $this->delete(route('admin.packages.itineraries.destroy', [$package, $itinerary]));

    $response->assertRedirect(route('admin.packages.itineraries.index', $package));
    $this->assertDatabaseMissing('package_itineraries', ['id' => $itinerary->id]);
});
