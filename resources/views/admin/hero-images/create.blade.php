@extends('admin.layouts.main')

@section('title', 'Tambah Hero Image')

@section('breadcrumb')
	<li><a href="{{ route('admin') }}">Dashboard</a></li>
	<li><a href="{{ route('admin.hero-images.index') }}">Hero Images</a></li>
	<li>Tambah</li>
@endsection

@section('content')
	<div class="max-w-2xl">
		<div class="d-card bg-base-100 shadow-sm">
			<div class="d-card-body">
				<div class="mb-6 flex items-center justify-between">
					<div>
						<h2 class="d-card-title font-display text-xl">Tambah Hero Image</h2>
						<p class="text-xs text-base-content/50">Unggah gambar baru untuk carousel landing page.</p>
					</div>
					<a href="{{ route('admin.hero-images.index') }}" class="d-btn d-btn-ghost d-btn-sm gap-2">
						<x-lucide-arrow-left class="h-4 w-4" />
						Kembali
					</a>
				</div>

				<form action="{{ route('admin.hero-images.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
					@csrf

					<div class="d-form-control w-full">
						<label class="label">
							<span class="label-text font-semibold">Judul / Alt Text</span>
						</label>
						<input type="text" name="title" value="{{ old('title') }}" placeholder="Contoh: Keberangkatan Umrah Extera Travel" class="d-input d-input-bordered w-full" />
						@error('title')
							<span class="text-xs text-error mt-1">{{ $message }}</span>
						@enderror
					</div>

					<div class="d-form-control w-full">
						<label class="label">
							<span class="label-text font-semibold">File Gambar <span class="text-error">*</span></span>
						</label>
						<input type="file" name="image" class="d-file-input d-file-input-bordered w-full" accept="image/*" required />
						<div class="label">
							<span class="label-text-alt text-base-content/50">Format yang didukung: JPEG, PNG, JPG, WEBP, SVG. Maksimal ukuran 2MB.</span>
						</div>
						@error('image')
							<span class="text-xs text-error mt-1">{{ $message }}</span>
						@enderror
					</div>

					<div class="pt-4 flex gap-2">
						<button type="submit" class="d-btn d-btn-primary">
							<x-lucide-save class="h-4 w-4 mr-2" />
							Simpan Gambar
						</button>
						<a href="{{ route('admin.hero-images.index') }}" class="d-btn d-btn-ghost">Batal</a>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection
