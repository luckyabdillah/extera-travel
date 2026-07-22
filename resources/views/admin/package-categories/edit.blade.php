@extends('admin.layouts.main')

@section('title', 'Edit Kategori Paket')

@section('breadcrumb')
	<li><a href="{{ route('admin') }}">Dashboard</a></li>
	<li><a href="{{ route('admin.package-categories.index') }}">Kategori Paket</a></li>
	<li>Edit</li>
@endsection

@section('content')
	<div class="max-w-2xl">
		<div class="d-card bg-base-100 shadow-sm">
			<div class="d-card-body">
				<div class="mb-6 flex items-center justify-between">
					<div>
						<h2 class="d-card-title font-display text-xl">Edit Kategori Paket</h2>
					</div>
					<a href="{{ route('admin.package-categories.index') }}" class="d-btn d-btn-ghost d-btn-sm gap-2">
						<x-lucide-arrow-left class="h-4 w-4" />
						Kembali
					</a>
				</div>

				<form action="{{ route('admin.package-categories.update', $packageCategory) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
					@csrf
					@method('PUT')

					<div class="d-form-control w-full">
						<label class="label">
							<span class="label-text font-semibold">Nama Kategori <span class="text-error">*</span></span>
						</label>
						<input type="text" name="name" value="{{ old('name', $packageCategory->name) }}" class="d-input d-input-bordered w-full" required />
						@error('name')
							<span class="text-xs text-error mt-1">{{ $message }}</span>
						@enderror
					</div>

					<div class="d-form-control w-full">
						<label class="label">
							<span class="label-text font-semibold">Gambar Cover Saat Ini</span>
						</label>
						@if($packageCategory->image_cover)
							<div class="mb-3 flex items-start gap-3">
								<img src="{{ asset('storage/' . $packageCategory->image_cover) }}" alt="{{ $packageCategory->name }}" class="h-32 w-auto object-cover rounded-lg border border-base-300 shadow-sm" />
								<button type="button" onclick="if(confirm('Hapus gambar cover ini?')) document.getElementById('deleteImageCoverForm').submit()" class="d-btn d-btn-square d-btn-ghost d-btn-sm text-error shrink-0" title="Hapus Cover">
									<x-lucide-trash-2 class="h-4 w-4" />
								</button>
							</div>
						@else
							<p class="text-sm text-base-content/50 mb-3">Belum ada cover.</p>
						@endif
					</div>

					<div class="d-form-control w-full">
						<label class="label">
							<span class="label-text font-semibold">Ganti Cover <span class="text-base-content/50">(Opsional)</span></span>
						</label>
						<input type="file" name="image_cover" class="d-file-input d-file-input-bordered w-full" accept="image/*" />
						<div class="label">
							<span class="label-text-alt text-base-content/50">Kosongkan jika tidak ingin mengganti. Format: JPEG, PNG, JPG, WEBP, SVG. Maks 2MB.</span>
						</div>
						@error('image_cover')
							<span class="text-xs text-error mt-1">{{ $message }}</span>
						@enderror
					</div>

					<div class="d-form-control w-full">
						<label class="label cursor-pointer justify-start gap-3">
							<input type="checkbox" name="mark_as_favorite" value="1" class="d-checkbox d-checkbox-primary" {{ $packageCategory->mark_as_favorite ? 'checked' : '' }} />
							<span class="label-text font-semibold">Tandai sebagai favorit</span>
						</label>
					</div>

					<div class="pt-4 flex gap-2">
						<button type="submit" class="d-btn d-btn-primary">
							<x-lucide-save class="h-4 w-4 mr-2" />
							Simpan Perubahan
						</button>
						<a href="{{ route('admin.package-categories.index') }}" class="d-btn d-btn-ghost">Batal</a>
					</div>
				</form>

				<form id="deleteImageCoverForm" action="{{ route('admin.package-categories.delete-image-cover', $packageCategory) }}" method="POST" class="hidden">
					@csrf
					@method('DELETE')
				</form>
			</div>
		</div>
	</div>
@endsection