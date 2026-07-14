<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HeroImageController;
use App\Http\Controllers\GalleryController;
use App\Models\HeroImage;

Route::get('/', function () {
    $heroImages = HeroImage::latest()->get();
    $galleries = App\Models\Gallery::latest()->get();
    return view('index', compact('heroImages', 'galleries'));
});

Route::get('/admin', function () {
    return view('admin.index');
})->name('admin');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('hero-images', HeroImageController::class);
    Route::resource('galleries', GalleryController::class);
});
