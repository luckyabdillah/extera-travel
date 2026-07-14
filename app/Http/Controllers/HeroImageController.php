<?php

namespace App\Http\Controllers;

use App\Models\HeroImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroImageController extends Controller
{
    public function index()
    {
        $heroImages = HeroImage::latest()->get();
        return view('admin.hero-images.index', compact('heroImages'));
    }

    public function create()
    {
        return view('admin.hero-images.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $path = $request->file('image')->store('hero-images', 'public');

        HeroImage::create([
            'title' => $request->title,
            'path' => $path,
        ]);

        return redirect()->route('admin.hero-images.index')->with('success', 'Hero image berhasil ditambahkan.');
    }

    public function edit(HeroImage $heroImage)
    {
        return view('admin.hero-images.edit', compact('heroImage'));
    }

    public function update(Request $request, HeroImage $heroImage)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $path = $heroImage->path;
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($heroImage->path);
            $path = $request->file('image')->store('hero-images', 'public');
        }

        $heroImage->update([
            'title' => $request->title,
            'path' => $path,
        ]);

        return redirect()->route('admin.hero-images.index')->with('success', 'Hero image berhasil diperbarui.');
    }

    public function destroy(HeroImage $heroImage)
    {
        Storage::disk('public')->delete($heroImage->path);
        $heroImage->delete();

        return redirect()->route('admin.hero-images.index')->with('success', 'Hero image berhasil dihapus.');
    }
}
