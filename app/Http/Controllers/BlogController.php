<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::latest()->get();
        return view("admin.blogs.index", compact("blogs"));
    }

    public function create()
    {
        return view("admin.blogs.create");
    }

    public function store(Request $request)
    {
        $request->validate([
            "title" => "required|string|max:255",
            "image_cover" => "nullable|image|mimes:jpeg,png,jpg,webp|max:2048",
            "content" => "required|string",
        ]);

        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $counter = 1;
        while (Blog::where("slug", $slug)->exists()) {
            $slug = $originalSlug . "-" . $counter;
            $counter++;
        }

        $data = [
            "title" => $request->title,
            "slug" => $slug,
            "content" => $request->content,
        ];

        if ($request->hasFile("image_cover")) {
            $data["image_cover"] = $request->file("image_cover")->store("blog-covers", "public");
        }

        Blog::create($data);

        return redirect()->route("admin.blogs.index")->with("success", "Artikel blog berhasil ditambahkan.");
    }

    public function edit(Blog $blog)
    {
        return view("admin.blogs.edit", compact("blog"));
    }

    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            "title" => "required|string|max:255",
            "image_cover" => "nullable|image|mimes:jpeg,png,jpg,webp|max:2048",
            "content" => "required|string",
        ]);

        $oldImagePaths = $this->extractBlogImagePaths($blog->content);
        $newImagePaths = $this->extractBlogImagePaths($request->content);

        $data = [
            "title" => $request->title,
            "content" => $request->content,
        ];

        if ($request->hasFile("image_cover")) {
            if ($blog->image_cover) {
                Storage::disk("public")->delete($blog->image_cover);
            }
            $data["image_cover"] = $request->file("image_cover")->store("blog-covers", "public");
        }

        if ($request->title !== $blog->title) {
            $slug = Str::slug($request->title);
            $originalSlug = $slug;
            $counter = 1;
            while (Blog::where("slug", $slug)->where("id", "!=", $blog->id)->exists()) {
                $slug = $originalSlug . "-" . $counter;
                $counter++;
            }
            $data["slug"] = $slug;
        }

        $blog->update($data);

        $this->deleteBlogImages(array_diff($oldImagePaths, $newImagePaths));

        return redirect()->route("admin.blogs.index")->with("success", "Artikel blog berhasil diperbarui.");
    }

    public function destroy(Blog $blog)
    {
        $this->deleteBlogImages($this->extractBlogImagePaths($blog->content));
        if ($blog->image_cover) {
            Storage::disk("public")->delete($blog->image_cover);
        }
        $blog->delete();

        return redirect()->route("admin.blogs.index")->with("success", "Artikel blog berhasil dihapus.");
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            "image" => "required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048",
        ]);

        $path = $request->file("image")->store("blog-images", "public");

        return response()->json([
            "url" => Storage::disk("public")->url($path),
        ]);
    }

    private function extractBlogImagePaths(string $content): array
    {
        $pattern = "/<img[^>]+src=[\"']([^\"']+)[\"']/i";
        preg_match_all($pattern, $content, $matches);

        return collect($matches[1] ?? [])
            ->map(function (string $url) {
                $path = parse_url($url, PHP_URL_PATH) ?: $url;
                $path = ltrim($path, "/");

                return Str::startsWith($path, "storage/") ? Str::after($path, "storage/") : null;
            })
            ->filter(fn ($path) => is_string($path) && Str::startsWith($path, "blog-images/"))
            ->values()
            ->all();
    }

    private function deleteBlogImages(array $paths): void
    {
        foreach ($paths as $path) {
            Storage::disk("public")->delete($path);
        }
    }
}