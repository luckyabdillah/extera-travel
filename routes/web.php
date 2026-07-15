<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HeroImageController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PackageCategoryController;
use App\Http\Controllers\PackageController;
use App\Models\HeroImage;

Route::get('/', function () {
    $heroImages = HeroImage::latest()->get();
    $galleries = App\Models\Gallery::latest()->get();
    $packageCategories = App\Models\PackageCategory::with(['packages.prices'])->latest()->get();
    return view('index', compact('heroImages', 'galleries', 'packageCategories'));
});

Route::get('/blogs', function () {
    $blogs = App\Models\Blog::latest()->paginate(9);
    return view('blogs.index', compact('blogs'));
});

Route::get('/blogs/{blog:slug}', function (App\Models\Blog $blog) {
    return view('blogs.show', compact('blog'));
})->name('blogs.show');


Route::get('/packages', function (Illuminate\Http\Request $request) {
    $query = App\Models\Package::with(['category', 'prices']);

    if ($request->filled('category_id')) {
        $query->where('package_category_id', $request->category_id);
    }

    if ($request->filled('month')) {
        $query->whereYear('date', substr($request->month, 0, 4))
              ->whereMonth('date', substr($request->month, 5, 2));
    }

    if ($request->boolean('available')) {
        $query->where('quota', '>', 0);
    }

    $packages = $query->orderBy('date')->get()->groupBy(function ($p) {
        return \Carbon\Carbon::parse($p->date)->format('F Y');
    });

    $months = App\Models\Package::get()
        ->map(fn ($p) => \Carbon\Carbon::parse($p->date)->format('Y-m'))
        ->unique()
        ->sort()
        ->values();

    $categories = App\Models\PackageCategory::all();

    return view('packages.index', compact('packages', 'months', 'categories'));
});


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
    Route::post('blogs/upload-image', [BlogController::class, 'uploadImage'])->name('blogs.upload-image');
    Route::resource('blogs', BlogController::class);
    Route::get('package-categories/{uuid}/restore', [PackageCategoryController::class, 'restore'])->name('package-categories.restore');
    Route::resource('package-categories', PackageCategoryController::class);
    Route::resource('packages', PackageController::class);
});
