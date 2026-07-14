@extends('admin.layouts.main')

@section('title', 'Edit Hero Image')

@section('breadcrumb')
	<li><a href="{{ route('admin') }}">Dashboard</a></li>
	<li><a href="{{ route('admin.hero-images.index') }}">Hero Images</a></li>
	<li>Edit</li>
@endsection

@section('content')
	<div class="max-w-2xl">
		<div class="d-card bg-base-100 shadow-sm">
			<div class="d-card-body">
				<div class="mb-6 flex items-center justify-between">
					<div>
						<h2 class="d-card-title font-display text-xl">Edit Hero Image</h2>
						<p class="text-xs text-base-content/50">Perbarui judul atau ganti gambar carousel.</p>
					</div>
					<a href="{{ route('admin.hero-images.index') }}" class="d-btn d-btn-ghost d-btn-sm gap-2">
						<x-lucide-arrow-left class="h-4 w-4" />
						Kembali
					</a>
				</div>

				<form action="{{ route('admin.hero-images.update', $heroImage) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
					@csrf
					@method('PUT')

					<div class="d-form-control w-full">
						<label class="label">
							<span class="label-text font-semibold">Judul / Alt Text</span>
						</label>
						<input type="text" name="title" value="{{ old('title', $heroImage->title) }}" placeholder="Contoh: Keberangkatan Umrah Extera Travel" class="d-input d-input-bordered w-full" />
						@error('title')
							<span class="text-xs text-error mt-1">{{ $message }}</span>
						@enderror
					</div>

					<div class="d-form-control w-full">
						<label class="label">
							<span class="label-text font-semibold">Gambar Saat Ini</span>
						</label>
						<div class="mb-3">
							<img src="{{ asset('storage/' . $heroImage->path) }}" alt="{{ $heroImage->title ?? 'Hero Image' }}" class="h-40 w-auto object-cover rounded-lg border border-base-300 shadow-sm" />
						</div>
					</div>

					<div class="d-form-control w-full">
						<label class="label">
							<span class="label-text font-semibold">Ganti Gambar <span class="text-base-content/50">(Opsional)</span></span>
						</label>
						<input type="file" name="image" class="d-file-input d-file-input-bordered w-full" accept="image/*" />
						<div class="label">
							<span class="label-text-alt text-base-content/50">Kosongkan jika tidak ingin mengganti gambar. Format: JPEG, PNG, JPG, WEBP, SVG. Maks 2MB.</span>
						</div>
						@error('image')
							<span class="text-xs text-error mt-1">{{ $message }}</span>
						@enderror
					</div>

					<div class="pt-4 flex gap-2">
						<button type="submit" class="d-btn d-btn-primary">
							<x-lucide-save class="h-4 w-4 mr-2" />
							Simpan Perubahan
						</button>
						<a href="{{ route('admin.hero-images.index') }}" class="d-btn d-btn-ghost">Batal</a>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection
