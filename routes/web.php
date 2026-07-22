<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HeroImageController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\PackageCategoryController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PackageItineraryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionDetailController;
use App\Http\Controllers\PreferenceController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ReportController;
use App\Models\HeroImage;

Route::get('/custom-package-mail-preview', function () {
    $data = [
        'name' => 'John Doe',
        'email' => 'john.doe@example.com',
        'phone' => '081234567890',
        'total_pax' => 4,
        'departure_month' => '2024-07',
        'destination' => 'Mekkah',
        'duration' => '7 hari',
        'destination_label' => 'Mekkah & Madinah',
        'duration_label' => '7 Hari',
        'budget_label' => 'Rp 25 - 35 Juta',
        'notes' => null,
    ];
    return new App\Mail\CustomPackageMail($data);
});

Route::get('/custom-package-internal-mail-preview', function () {
    $data = [
        'name' => 'John Doe',
        'email' => 'john.doe@example.com',
        'phone' => '081234567890',
        'total_pax' => 4,
        'departure_month' => '2024-07',
        'destination' => 'Mekkah',
        'duration' => '7 hari',
        'destination_label' => 'Mekkah & Madinah',
        'duration_label' => '7 Hari',
        'budget_label' => 'Rp 25 - 35 Juta',
        'notes' => null,
    ];
    return new App\Mail\CustomPackageInternalMail($data);
});

Route::get('/order-confirmation-mail-preview', function () {
    $transaction = App\Models\Transaction::latest()->first();
    return new App\Mail\OrderConfirmationMail($transaction);
});

Route::get('/', function () {
    $heroImages = HeroImage::latest()->get();
    $galleries = App\Models\Gallery::latest()->get();
    $packageCategories = App\Models\PackageCategory::with(['packages.prices'])->latest()->get();
    $hotelsByCity = App\Models\Hotel::select('id', 'name', 'city', 'latitude', 'longitude')->orderBy('city')->orderBy('name')->get()->groupBy('city');
    $hotelsByCityCount = $hotelsByCity->count();
    $gridCols = $hotelsByCityCount % 3 === 0 ? 3 : 2;
    $lastHotelFullWidth = $hotelsByCityCount % 5 == 0 || $hotelsByCityCount % 7 == 0 ? true : false;
    
    return view('index', compact('heroImages', 'galleries', 'packageCategories', 'hotelsByCity', 'hotelsByCityCount', 'gridCols', 'lastHotelFullWidth'));
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
        'itinerary_pdf_url' => $package->itinerary_pdf ? asset('storage/' . $package->itinerary_pdf) : null,
        'itinerary_pdf_dynamic_url' => route('packages.itinerary-pdf', $package),
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


Route::get('/packages/{package}/itinerary-pdf', function (App\Models\Package $package) {
    $package->load(['prices', 'category', 'itineraries']);

    $pdf = Barryvdh\DomPDF\Facade\Pdf::loadView('packages.itinerary-pdf', compact('package'));

    return $pdf->stream('itinerary-' . $package->slug . '.pdf');
})->name('packages.itinerary-pdf');

Route::get('/checkout/{package}', [OrderController::class, 'checkout'])->name('checkout');
Route::post('/checkout/{package}/customers', [OrderController::class, 'storeCustomers'])->name('checkout.customers');
Route::get('/checkout/{package}/confirm', [OrderController::class, 'getConfirmation'])->name('checkout.getConfirmation');
Route::post('/checkout/{package}/confirm', [OrderController::class, 'confirm'])->name('checkout.confirm');
Route::get('/checkout/success/{transaction}', [OrderController::class, 'success'])->name('checkout.success');
Route::post('/custom-package', function (Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:100',
        'total_pax' => 'nullable|integer|min:1|max:100',
        'departure_month' => 'nullable|string|max:100',
        'destination' => 'nullable|string|max:255',
        'duration' => 'nullable|string|max:100',
        'budget' => 'nullable|string|max:100',
        'notes' => 'nullable|string|max:5000',
    ]);

    $destinationLabels = [
        'mekkah-madinah' => 'Mekkah & Madinah',
        'mekkah-madinah-jeddah' => 'Mekkah, Madinah & Jeddah',
        'mekkah-madinah-turki' => 'Mekkah, Madinah & Turki',
        'mekkah-madinah-mesir' => 'Mekkah, Madinah & Mesir',
        'mekkah-madinah-yordania' => 'Mekkah, Madinah & Yordania',
        'umrah-plus' => 'Umrah Plus (Lainnya)',
        'haji' => 'Haji Khusus',
        'wisata-religi' => 'Wisata Religi Nusantara',
        'other' => 'Lainnya',
    ];

    $durationLabels = [
        '7' => '7 Hari',
        '9' => '9 Hari',
        '10' => '10 Hari',
        '12' => '12 Hari',
        '14' => '14 Hari',
        '21' => '21 Hari',
        'flexible' => 'Fleksibel',
    ];

    $budgetLabels = [
        '<25' => '< Rp 25 Juta',
        '25-35' => 'Rp 25 - 35 Juta',
        '35-50' => 'Rp 35 - 50 Juta',
        '50-75' => 'Rp 50 - 75 Juta',
        '75-100' => 'Rp 75 - 100 Juta',
        '>100' => '> Rp 100 Juta',
        'flexible' => 'Belum Tahu / Fleksibel',
    ];

    $data = array_merge($validated, [
        'destination_label' => $destinationLabels[$validated['destination']] ?? $validated['destination'],
        'duration_label' => $durationLabels[$validated['duration']] ?? $validated['duration'],
        'budget_label' => $budgetLabels[$validated['budget']] ?? $validated['budget'],
        'total_pax' => $validated['total_pax'] ?? 1,
        'departure_month' => $validated['departure_month'] ?? '',
        'notes' => $validated['notes'] ?? '',
    ]);

    try {
        \Illuminate\Support\Facades\Mail::to($data['email'])
            ->send(new \App\Mail\CustomPackageMail($data));
    } catch (\Exception $e) {
        \Log::error('Failed to send custom package customer email: ' . $e->getMessage());
    }

    try {
        \Illuminate\Support\Facades\Mail::to(config('mail.from.address'))
            ->send(new \App\Mail\CustomPackageInternalMail($data));
    } catch (\Exception $e) {
        \Log::error('Failed to send custom package internal email: ' . $e->getMessage());
    }

    return redirect('/#kontak')->with('success', 'Permintaan paket kustom berhasil dikirim! Tim kami akan menghubungi kamu dalam 1x24 jam.');
})->name('custom-package.submit');

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

Route::get('/contact', function () { return view('contact'); });

Route::get('/faq', function () {
    $faqs = App\Models\Faq::latest()->get();
    return view('faq', compact('faqs'));
});

Route::get('/admin', function () {
    $totalJamaah = App\Models\Customer::count();
    $bookingBaru = App\Models\Transaction::where('created_at', '>=', now()->startOfWeek())->count();
    $menungguKonfirmasi = App\Models\Transaction::where('status', 'pending')->count();
    $paketAktif = App\Models\Package::where('quota', '>', 0)->where('date', '>=', now())->count();
    $bookingTerbaru = App\Models\Transaction::with('package')->latest()->take(5)->get();

    return view('admin.index', compact('totalJamaah', 'bookingBaru', 'menungguKonfirmasi', 'paketAktif', 'bookingTerbaru'));
})->name('admin');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('hero-images', HeroImageController::class);
    Route::resource('galleries', GalleryController::class);
    Route::resource('faqs', FaqController::class);
    Route::resource('hotels', HotelController::class);
    Route::post('blogs/upload-image', [BlogController::class, 'uploadImage'])->name('blogs.upload-image');
    Route::resource('blogs', BlogController::class);
    Route::get('package-categories/{uuid}/restore', [PackageCategoryController::class, 'restore'])->name('package-categories.restore');
    Route::delete('package-categories/{packageCategory}/image-cover', [PackageCategoryController::class, 'deleteImageCover'])->name('package-categories.delete-image-cover');
    Route::resource('package-categories', PackageCategoryController::class);
    Route::get('packages/{uuid}/restore', [PackageController::class, 'restore'])->name('packages.restore');
    Route::delete('packages/{package}/flyer', [PackageController::class, 'deleteFlyer'])->name('packages.delete-flyer');
    Route::delete('packages/{package}/itinerary-pdf', [PackageController::class, 'deleteItineraryPdf'])->name('packages.delete-itinerary-pdf');
    Route::post('packages/{package}/generate-flyer', [PackageController::class, 'generateFlyer'])->name('packages.generate-flyer');
    Route::resource('packages', PackageController::class);
    Route::resource('packages.itineraries', PackageItineraryController::class)->except(['show']);
    Route::resource('transactions', TransactionController::class)->only(['index', 'create', 'store', 'show', 'update']);
    Route::get('transactions/{transaction}/pdf', [TransactionController::class, 'exportPdf'])->name('transactions.pdf');
    Route::get('transactions/{transaction}/quotation-pdf', [TransactionController::class, 'exportQuotationPdf'])->name('transactions.quotation-pdf');
    Route::post('transactions/{transaction}/details', [TransactionDetailController::class, 'store'])->name('transactions.details.store');
    Route::patch('transactions/{transaction}/details/{detail}', [TransactionDetailController::class, 'update'])->name('transactions.details.update');
    Route::delete('transactions/{transaction}/details/{detail}', [TransactionDetailController::class, 'destroy'])->name('transactions.details.destroy');
    Route::resource('customers', CustomerController::class);

    Route::get('settings/preferences', [PreferenceController::class, 'edit'])->name('settings.preferences');
    Route::put('settings/preferences', [PreferenceController::class, 'update'])->name('settings.preferences.update');
    Route::get('reports/financial', [ReportController::class, 'financial'])->name('reports.financial');
    Route::get('reports/financial/pdf', [ReportController::class, 'financialPdf'])->name('reports.financial.pdf');
});

