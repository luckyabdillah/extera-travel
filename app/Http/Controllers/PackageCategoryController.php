<?php

namespace App\Http\Controllers;

use App\Models\PackageCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PackageCategoryController extends Controller
{
    public function index()
    {
        $categories = PackageCategory::withTrashed()->latest()->get();
        return view('admin.package-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.package-categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image_cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'mark_as_favorite' => 'nullable|boolean',
        ]);

        $path = null;
        if ($request->hasFile('image_cover')) {
            $path = $request->file('image_cover')->store('package-categories', 'public');
        }

        PackageCategory::create([
            'name' => $request->name,
            'image_cover' => $path,
            'mark_as_favorite' => $request->boolean('mark_as_favorite'),
        ]);

        return redirect()->route('admin.package-categories.index')
            ->with('success', 'Kategori paket berhasil ditambahkan.');
    }

    public function edit(PackageCategory $packageCategory)
    {
        return view('admin.package-categories.edit', compact('packageCategory'));
    }

    public function update(Request $request, PackageCategory $packageCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image_cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'mark_as_favorite' => 'nullable|boolean',
        ]);

        $path = $packageCategory->image_cover;
        if ($request->hasFile('image_cover')) {
            if ($packageCategory->image_cover) {
                Storage::disk('public')->delete($packageCategory->image_cover);
            }
            $path = $request->file('image_cover')->store('package-categories', 'public');
        }

        $packageCategory->update([
            'name' => $request->name,
            'image_cover' => $path,
            'mark_as_favorite' => $request->boolean('mark_as_favorite'),
        ]);

        return redirect()->route('admin.package-categories.index')
            ->with('success', 'Kategori paket berhasil diperbarui.');
    }

    public function destroy(PackageCategory $packageCategory)
    {
        if ($packageCategory->image_cover) {
            Storage::disk('public')->delete($packageCategory->image_cover);
        }
        $packageCategory->delete();

        return redirect()->route('admin.package-categories.index')
            ->with('success', 'Kategori paket berhasil dihapus.');
    }


    public function deleteImageCover(PackageCategory $packageCategory)
    {
        if ($packageCategory->image_cover) {
            Storage::disk("public")->delete($packageCategory->image_cover);
            $packageCategory->update(["image_cover" => null]);
        }

        return redirect()->route("admin.package-categories.edit", $packageCategory)
            ->with("success", "Gambar cover berhasil dihapus.");
    }

    public function restore($uuid)
    {
        $category = PackageCategory::withTrashed()->where('uuid', $uuid)->firstOrFail();
        $category->restore();

        return redirect()->route('admin.package-categories.index')
            ->with('success', 'Kategori paket berhasil dipulihkan.');
    }
}
