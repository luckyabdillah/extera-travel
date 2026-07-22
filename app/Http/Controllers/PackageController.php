<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\PackageCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\FlyerGenerator;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::withTrashed()->with(['category', 'prices'])->latest()->get();
        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        $categories = PackageCategory::all();
        return view('admin.packages.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'package_category_id' => 'nullable|exists:package_categories,id',
            'flyer_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'flight_by' => 'nullable|string|max:255',
            'date' => 'required|date',
            'total_days' => 'required|integer|min:1|max:255',
            'quota' => 'required|integer|min:0|max:32767',
            'inclusions' => 'nullable|string',
            'exclusions' => 'nullable|string',
            'requirements' => 'nullable|string',
            'itinerary_pdf' => 'nullable|mimes:pdf|max:10240',
            'prices' => 'nullable|array',
            'prices.*.currency' => 'required|string|max:10',
            'prices.*.price_type' => 'required|string|max:50',
            'prices.*.amount' => 'required|numeric|min:0',
        ]);

        $flyerPath = null;
        if ($request->hasFile('flyer_path')) {
            $flyerPath = $request->file('flyer_path')->store('packages', 'public');
        }

        $itineraryPdf = null;
        if ($request->hasFile('itinerary_pdf')) {
            $itineraryPdf = $request->file('itinerary_pdf')->store('packages', 'public');
        }

        $package = Package::create([
            'title' => $request->title,
            'package_category_id' => $request->package_category_id,
            'flyer_path' => $flyerPath,
            'flight_by' => $request->flight_by,
            'date' => $request->date,
            'total_days' => $request->total_days,
            'quota' => $request->quota,
            'inclusions' => $request->inclusions,
            'exclusions' => $request->exclusions,
            'requirements' => $request->requirements,
            'itinerary_pdf' => $itineraryPdf,
        ]);

        if ($request->prices) {
            foreach ($request->prices as $price) {
                $package->prices()->create([
                    'currency' => $price['currency'],
                    'price_type' => $price['price_type'],
                    'price' => $price['amount'],
                ]);
            }
        }

        return redirect()->route('admin.packages.index')
            ->with('success', 'Paket berhasil ditambahkan.');
    }

    public function edit(Package $package)
    {
        $package->load('prices');
        $categories = PackageCategory::all();
        return view('admin.packages.edit', compact('package', 'categories'));
    }

    public function update(Request $request, Package $package)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'package_category_id' => 'nullable|exists:package_categories,id',
            'flyer_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'flight_by' => 'nullable|string|max:255',
            'date' => 'required|date',
            'total_days' => 'required|integer|min:1|max:255',
            'quota' => 'required|integer|min:0|max:32767',
            'inclusions' => 'nullable|string',
            'exclusions' => 'nullable|string',
            'requirements' => 'nullable|string',
            'itinerary_pdf' => 'nullable|mimes:pdf|max:10240',
            'prices' => 'nullable|array',
            'prices.*.currency' => 'required|string|max:10',
            'prices.*.price_type' => 'required|string|max:50',
            'prices.*.amount' => 'required|numeric|min:0',
        ]);

        $data = [
            'title' => $request->title,
            'package_category_id' => $request->package_category_id,
            'flight_by' => $request->flight_by,
            'date' => $request->date,
            'total_days' => $request->total_days,
            'quota' => $request->quota,
            'inclusions' => $request->inclusions,
            'exclusions' => $request->exclusions,
            'requirements' => $request->requirements,
        ];

        if ($request->hasFile('flyer_path')) {
            if ($package->flyer_path) {
                Storage::disk('public')->delete($package->flyer_path);
            }
            $data['flyer_path'] = $request->file('flyer_path')->store('packages', 'public');
        }

        if ($request->hasFile('itinerary_pdf')) {
            if ($package->itinerary_pdf) {
                Storage::disk('public')->delete($package->itinerary_pdf);
            }
            $data['itinerary_pdf'] = $request->file('itinerary_pdf')->store('packages', 'public');
        }

        $package->update($data);

        // Sync prices: delete existing and recreate
        $package->prices()->delete();
        if ($request->prices) {
            foreach ($request->prices as $price) {
                $package->prices()->create([
                    'currency' => $price['currency'],
                    'price_type' => $price['price_type'],
                    'price' => $price['amount'],
                ]);
            }
        }

        return redirect()->route('admin.packages.index')
            ->with('success', 'Paket berhasil diperbarui.');
    }

    public function destroy(Package $package)
    {
        $package->delete();

        return redirect()->route('admin.packages.index')
            ->with('success', 'Paket berhasil dihapus.');
    }

    
    public function deleteFlyer(Package $package)
    {
        if ($package->flyer_path) {
            Storage::disk("public")->delete($package->flyer_path);
            $package->update(["flyer_path" => null]);
        }

        return redirect()->route("admin.packages.edit", $package)
            ->with("success", "Flyer berhasil dihapus.");
    }

    public function deleteItineraryPdf(Package $package)
    {
        if ($package->itinerary_pdf) {
            Storage::disk("public")->delete($package->itinerary_pdf);
            $package->update(["itinerary_pdf" => null]);
        }

        return redirect()->route("admin.packages.edit", $package)
            ->with("success", "Itinerary PDF berhasil dihapus.");
    }



    public function generateFlyer(Package $package)
    {
        $package->load(["prices", "category"]);

        $path = FlyerGenerator::generate($package);

        $package->update(["flyer_path" => $path]);

        return redirect()->route("admin.packages.edit", $package)
            ->with("success", "Flyer berhasil digenerate.");
    }

    public function restore($uuid)
    {
        $package = Package::withTrashed()->where('uuid', $uuid)->firstOrFail();
        $package->restore();

        return redirect()->route('admin.packages.index')
            ->with('success', 'Paket berhasil dipulihkan.');
    }
}
