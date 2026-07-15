<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\PackageItinerary;
use Illuminate\Http\Request;

class PackageItineraryController extends Controller
{
    public function index(Package $package)
    {
        $itineraries = $package->itineraries()->latest()->get();
        return view('admin.packages.itineraries.index', compact('package', 'itineraries'));
    }

    public function create(Package $package)
    {
        return view('admin.packages.itineraries.create', compact('package'));
    }

    public function store(Request $request, Package $package)
    {
        $request->validate([
            'marker' => 'required|string|max:50',
            'title' => 'required|string|max:100',
            'itinerary' => 'required|string',
            'accommodation_place' => 'nullable|string|max:100',
            'accommodation_days' => 'nullable|integer|min:0',
            'meals' => 'nullable|string|max:100',
            'optional_activities' => 'nullable|string',
            'included_activities' => 'nullable|string',
            'special_information' => 'nullable|string',
        ]);

        $package->itineraries()->create($request->all());

        return redirect()->route('admin.packages.itineraries.index', $package)
            ->with('success', 'Itinerary berhasil ditambahkan.');
    }

    public function edit(Package $package, PackageItinerary $itinerary)
    {
        return view('admin.packages.itineraries.edit', compact('package', 'itinerary'));
    }

    public function update(Request $request, Package $package, PackageItinerary $itinerary)
    {
        $request->validate([
            'marker' => 'required|string|max:50',
            'title' => 'required|string|max:100',
            'itinerary' => 'required|string',
            'accommodation_place' => 'nullable|string|max:100',
            'accommodation_days' => 'nullable|integer|min:0',
            'meals' => 'nullable|string|max:100',
            'optional_activities' => 'nullable|string',
            'included_activities' => 'nullable|string',
            'special_information' => 'nullable|string',
        ]);

        $itinerary->update($request->all());

        return redirect()->route('admin.packages.itineraries.index', $package)
            ->with('success', 'Itinerary berhasil diperbarui.');
    }

    public function destroy(Package $package, PackageItinerary $itinerary)
    {
        $itinerary->delete();

        return redirect()->route('admin.packages.itineraries.index', $package)
            ->with('success', 'Itinerary berhasil dihapus.');
    }
}
