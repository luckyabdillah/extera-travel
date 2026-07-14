<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HeroImageController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\BlogController;
use App\Models\HeroImage;

Route::get('/', function () {
    $heroImages = HeroImage::latest()->get();
    $galleries = App\Models\Gallery::latest()->get();
    return view('index', compact('heroImages', 'galleries'));
});

Route::get('/blog', function () {
    $blogs = App\Models\Blog::latest()->paginate(9);
    return view('blog.index', compact('blogs'));
});

Route::get('/blog/{blog:slug}', function (App\Models\Blog $blog) {
    return view('blog.show', compact('blog'));
})->name('blog.show');

Route::get('/faq', function () {
    $faqs = App\Models\Faq::latest()->get();
    return view('faq', compact('faqs'));
});

Route::get('/admin', function () {
    return view('admin.index');
})->name('admin');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('hero-images', HeroImageController::class);
    Route::resource('galleries', GalleryController::class);
    Route::resource('faqs', FaqController::class);
    Route::resource('blogs', BlogController::class);
});
