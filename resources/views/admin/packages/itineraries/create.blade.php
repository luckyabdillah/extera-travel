@extends('admin.layouts.main')

@section('title', 'Tambah Itinerary')

@section('breadcrumb')
	<li><a href="{{ route('admin') }}">Dashboard</a></li>
	<li><a href="{{ route('admin.packages.index') }}">Paket</a></li>
	<li><a href="{{ route('admin.packages.itineraries.index', $package) }}">Itinerary</a></li>
	<li>Tambah</li>
@endsection

@section('content')
	<div class="max-w-3xl">
		<div class="d-card bg-base-100 shadow-sm">
			<div class="d-card-body">
				<div class="mb-6 flex items-center justify-between">
					<h2 class="d-card-title font-display text-xl">Tambah Itinerary</h2>
					<a href="{{ route('admin.packages.itineraries.index', $package) }}" class="d-btn d-btn-ghost d-btn-sm gap-2">
						<x-lucide-arrow-left class="h-4 w-4" /> Kembali
					</a>
				</div>

				<form action="{{ route('admin.packages.itineraries.store', $package) }}" method="POST" class="space-y-4">
					@csrf
					<div class="grid gap-4 sm:grid-cols-2">
						<div class="d-form-control">
							<label class="label"><span class="label-text font-semibold">Marker <span class="text-error">*</span></span></label>
							<input type="text" name="marker" value="{{ old('marker') }}" placeholder="Contoh: HARI-1" class="d-input d-input-bordered w-full" required />
							@error('marker')<span class="text-xs text-error mt-1">{{ $message }}</span>@enderror
						</div>
						<div class="d-form-control">
							<label class="label"><span class="label-text font-semibold">Judul <span class="text-error">*</span></span></label>
							<input type="text" name="title" value="{{ old('title') }}" placeholder="Contoh: Kedatangan di Jeddah" class="d-input d-input-bordered w-full" required />
							@error('title')<span class="text-xs text-error mt-1">{{ $message }}</span>@enderror
						</div>
					</div>

					<div class="d-form-control">
						<label class="label"><span class="label-text font-semibold">Rincian Kegiatan <span class="text-error">*</span></span></label>
						<textarea name="itinerary" rows="5" class="d-textarea d-textarea-bordered w-full" required>{{ old('itinerary') }}</textarea>
						@error('itinerary')<span class="text-xs text-error mt-1">{{ $message }}</span>@enderror
					</div>

					<div class="grid gap-4 sm:grid-cols-2">
						<div class="d-form-control">
							<label class="label"><span class="label-text font-semibold">Akomodasi</span></label>
							<input type="text" name="accommodation_place" value="{{ old('accommodation_place') }}" placeholder="Nama hotel/makkah/madinah" class="d-input d-input-bordered w-full" />
							@error('accommodation_place')<span class="text-xs text-error mt-1">{{ $message }}</span>@enderror
						</div>
						<div class="d-form-control">
							<label class="label"><span class="label-text font-semibold">Lama Akomodasi (malam)</span></label>
							<input type="number" name="accommodation_days" value="{{ old('accommodation_days') }}" min="0" class="d-input d-input-bordered w-full" />
							@error('accommodation_days')<span class="text-xs text-error mt-1">{{ $message }}</span>@enderror
						</div>
					</div>

					<div class="grid gap-4 sm:grid-cols-3">
						<div class="d-form-control">
							<label class="label"><span class="label-text font-semibold">Makanan</span></label>
							<input type="text" name="meals" value="{{ old('meals') }}" placeholder="Sarapan, Makan Siang" class="d-input d-input-bordered w-full" />
							@error('meals')<span class="text-xs text-error mt-1">{{ $message }}</span>@enderror
						</div>
						<div class="d-form-control">
							<label class="label"><span class="label-text font-semibold">Kegiatan Termasuk</span></label>
							<input type="text" name="included_activities" value="{{ old('included_activities') }}" placeholder="Ziarah, Belanja" class="d-input d-input-bordered w-full" />
							@error('included_activities')<span class="text-xs text-error mt-1">{{ $message }}</span>@enderror
						</div>
						<div class="d-form-control">
							<label class="label"><span class="label-text font-semibold">Kegiatan Opsional</span></label>
							<input type="text" name="optional_activities" value="{{ old('optional_activities') }}" placeholder="Tour tambahan" class="d-input d-input-bordered w-full" />
							@error('optional_activities')<span class="text-xs text-error mt-1">{{ $message }}</span>@enderror
						</div>
					</div>

					<div class="d-form-control">
						<label class="label"><span class="label-text font-semibold">Informasi Khusus</span></label>
						<textarea name="special_information" rows="3" class="d-textarea d-textarea-bordered w-full">{{ old('special_information') }}</textarea>
						@error('special_information')<span class="text-xs text-error mt-1">{{ $message }}</span>@enderror
					</div>

					<div class="pt-4 flex gap-2">
						<button type="submit" class="d-btn d-btn-primary"><x-lucide-save class="h-4 w-4 mr-2" /> Simpan Itinerary</button>
						<a href="{{ route('admin.packages.itineraries.index', $package) }}" class="d-btn d-btn-ghost">Batal</a>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection