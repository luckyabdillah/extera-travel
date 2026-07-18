<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HeroImageController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PackageCategoryController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PackageItineraryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CustomerController;
use App\Models\HeroImage;

Route::get('/order-confirmation-mail-preview', function () {
    $transaction = App\Models\Transaction::latest()->first();
    return new App\Mail\OrderConfirmationMail($transaction);
});

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



Route::get('/api/packages/{package}', function (App\Models\Package $package) {
    $package->load(['category', 'prices', 'itineraries']);

    return response()->json([
        'title' => $package->title,
        'category' => $package->category?->name,
        'flight_by' => $package->flight_by,
        'date' => \Carbon\Carbon::parse($package->date)->locale('id')->isoFormat('DD MMMM YYYY'),
        'total_days' => $package->total_days,
        'quota' => $package->quota,
        'inclusions' => $package->inclusions,
        'exclusions' => $package->exclusions,
        'requirements' => $package->requirements,
        'prices' => $package->prices->map(fn ($p) => [
            'price_type' => $p->price_type,
            'currency' => $p->currency,
            'price' => number_format($p->price, 0, ',', '.'),
        ]),
        'itineraries' => $package->itineraries->map(fn ($i) => [
            'marker' => $i->marker,
            'title' => $i->title,
            'itinerary' => $i->itinerary,
            'accommodation_place' => $i->accommodation_place,
            'accommodation_days' => $i->accommodation_days,
            'meals' => $i->meals,
        ]),
    ]);
});



Route::get('/checkout/{package}', [OrderController::class, 'checkout'])->name('checkout');
Route::post('/checkout/{package}/customers', [OrderController::class, 'storeCustomers'])->name('checkout.customers');
Route::get('/checkout/{package}/confirm', [OrderController::class, 'getConfirmation'])->name('checkout.getConfirmation');
Route::post('/checkout/{package}/confirm', [OrderController::class, 'confirm'])->name('checkout.confirm');
Route::get('/checkout/success/{transaction}', [OrderController::class, 'success'])->name('checkout.success');

Route::get('/packages', function (Illuminate\Http\Request $request) {
    $query = App\Models\Package::with(['category', 'prices', 'itineraries']);

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
    Route::resource('packages.itineraries', PackageItineraryController::class)->except(['show']);
    Route::resource('transactions', TransactionController::class)->only(['index', 'show', 'update']);
    Route::resource('customers', CustomerController::class);
});
