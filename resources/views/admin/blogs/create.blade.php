@extends('admin.layouts.main')

@section('title', 'Tulis Artikel')

@section('breadcrumb')
	<li><a href="{{ route('admin') }}">Dashboard</a></li>
	<li><a href="{{ route('admin.blogs.index') }}">Blog</a></li>
	<li>Tulis</li>
@endsection

@section('content')
	<div class="max-w-4xl">
		<div class="d-card bg-base-100 shadow-sm">
			<div class="d-card-body">
				<div class="mb-6 flex items-center justify-between">
					<div>
						<h2 class="d-card-title font-display text-xl">Tulis Artikel Baru</h2>
					</div>
					<a href="{{ route('admin.blogs.index') }}" class="d-btn d-btn-ghost d-btn-sm gap-2">
						<x-lucide-arrow-left class="h-4 w-4" />
						Kembali
					</a>
				</div>

				<form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4" id="blogForm" data-blog-editor data-upload-url="{{ route('admin.blogs.upload-image') }}">
					@csrf

					<div class="d-form-control w-full">
						<label class="label">
							<span class="label-text font-semibold">Judul Artikel <span class="text-error">*</span></span>
						</label>
						<input type="text" name="title" value="{{ old('title') }}" class="d-input d-input-bordered w-full" required />
						@error('title')
							<span class="text-xs text-error mt-1">{{ $message }}</span>
						@enderror
					</div>

					<div class="d-form-control w-full">
						<label class="label">
							<span class="label-text font-semibold">Gambar Sampul</span>
						</label>
						<input type="file" name="image_cover" class="d-file-input d-file-input-bordered w-full" accept="image/*" />
						<div class="label">
							<span class="label-text-alt text-base-content/50">Format: JPEG, PNG, JPG, WEBP. Maks 2MB.</span>
						</div>
						@error('image_cover')
							<span class="text-xs text-error mt-1">{{ $message }}</span>
						@enderror
					</div>

					<div class="d-form-control w-full">
						<label class="label">
							<span class="label-text font-semibold">Konten <span class="text-error">*</span></span>
						</label>
						<div class="bg-base-100 rounded-lg overflow-hidden border border-base-300">
							<div id="editor-container" data-blog-editor-container class="h-96"></div>
						</div>
						<textarea name="content" id="content" data-blog-editor-input class="hidden">{{ old('content') }}</textarea>
						@error('content')
							<span class="text-xs text-error mt-1">{{ $message }}</span>
						@enderror
					</div>

					<div class="pt-4 flex gap-2">
						<button type="submit" class="d-btn d-btn-primary">
							<x-lucide-save class="h-4 w-4 mr-2" />
							Simpan Artikel
						</button>
						<a href="{{ route('admin.blogs.index') }}" class="d-btn d-btn-ghost">Batal</a>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection

@push('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    .ql-toolbar.ql-snow {
        border: none;
        border-bottom: 1px solid var(--fallback-bc,oklch(var(--bc)/0.2));
        background-color: var(--fallback-b2,oklch(var(--b2)/1));
        font-family: inherit;
    }
    .ql-container.ql-snow {
        border: none;
        font-family: inherit;
        font-size: 1rem;
    }
    .ql-editor {
        min-height: 24rem;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
@endpush