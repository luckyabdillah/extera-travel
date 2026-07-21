@extends('admin.layouts.main')

@section('title', 'Tambah Paket')

@section('breadcrumb')
	<li><a href="{{ route('admin') }}">Dashboard</a></li>
	<li><a href="{{ route('admin.packages.index') }}">Paket Perjalanan</a></li>
	<li>Tambah</li>
@endsection

@section('content')
	@php(\App\Helpers\PreferenceHelper::class)
	<div class="max-w-4xl">
		<div class="d-card bg-base-100 shadow-sm">
			<div class="d-card-body">
				<div class="mb-6 flex items-center justify-between">
					<div>
						<h2 class="d-card-title font-display text-xl">Tambah Paket Perjalanan</h2>
					</div>
					<a href="{{ route('admin.packages.index') }}" class="d-btn d-btn-ghost d-btn-sm gap-2">
						<x-lucide-arrow-left class="h-4 w-4" />
						Kembali
					</a>
				</div>

				<form action="{{ route('admin.packages.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
					@csrf

					<div class="grid gap-4 sm:grid-cols-2">
						<div class="d-form-control w-full sm:col-span-2">
							<label class="label">
								<span class="label-text font-semibold">Judul Paket <span class="text-error">*</span></span>
							</label>
							<input type="text" name="title" value="{{ old('title') }}" class="d-input d-input-bordered w-full" required />
							@error('title')
								<span class="text-xs text-error mt-1">{{ $message }}</span>
							@enderror
						</div>

						<div class="d-form-control w-full">
							<label class="label">
								<span class="label-text font-semibold">Kategori</span>
							</label>
							<select name="package_category_id" class="d-select d-select-bordered w-full">
								<option value="">Pilih kategori...</option>
								@foreach($categories as $cat)
									<option value="{{ $cat->id }}" {{ old('package_category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
								@endforeach
							</select>
							@error('package_category_id')
								<span class="text-xs text-error mt-1">{{ $message }}</span>
							@enderror
						</div>

						<div class="d-form-control w-full">
							<label class="label">
								<span class="label-text font-semibold">Maskapai</span>
							</label>
							<input type="text" name="flight_by" value="{{ old('flight_by') }}" placeholder="Contoh: Saudia Airlines" class="d-input d-input-bordered w-full" />
							@error('flight_by')
								<span class="text-xs text-error mt-1">{{ $message }}</span>
							@enderror
						</div>

						<div class="d-form-control w-full">
							<label class="label">
								<span class="label-text font-semibold">Tanggal Keberangkatan <span class="text-error">*</span></span>
							</label>
							<input type="date" name="date" value="{{ old('date') }}" class="d-input d-input-bordered w-full" required />
							@error('date')
								<span class="text-xs text-error mt-1">{{ $message }}</span>
							@enderror
						</div>

						<div class="d-form-control w-full">
							<label class="label">
								<span class="label-text font-semibold">Lama Perjalanan (hari) <span class="text-error">*</span></span>
							</label>
							<input type="number" name="total_days" value="{{ old('total_days', 9) }}" min="1" max="255" class="d-input d-input-bordered w-full" required />
							@error('total_days')
								<span class="text-xs text-error mt-1">{{ $message }}</span>
							@enderror
						</div>

						<div class="d-form-control w-full">
							<label class="label">
								<span class="label-text font-semibold">Kuota <span class="text-error">*</span></span>
							</label>
							<input type="number" name="quota" value="{{ old('quota', 25) }}" min="0" max="32767" class="d-input d-input-bordered w-full" required />
							@error('quota')
								<span class="text-xs text-error mt-1">{{ $message }}</span>
							@enderror
						</div>

						<div class="d-form-control w-full sm:col-span-2">
							<label class="label">
								<span class="label-text font-semibold">Flyer / Gambar Paket</span>
							</label>
							<input type="file" name="flyer_path" class="d-file-input d-file-input-bordered w-full" accept="image/*" />
							<div class="label">
								<span class="label-text-alt text-base-content/50">Format: JPEG, PNG, JPG, WEBP, SVG. Maks 2MB.</span>
							</div>
							@error('flyer_path')
								<span class="text-xs text-error mt-1">{{ $message }}</span>
							@enderror
						</div>
					</div>

					<div class="d-card bg-base-200/50 shadow-none">
						<div class="d-card-body p-4">
							<div class="flex items-center justify-between mb-2">
								<h3 class="font-display text-base font-semibold">Harga Paket</h3>
								<button type="button" id="addPriceRow" class="d-btn d-btn-outline d-btn-primary d-btn-xs gap-1">
									<x-lucide-plus class="h-3 w-3" />
									Tambah Harga
								</button>
							</div>
							<div id="priceRows" class="space-y-2">
								<div class="price-row flex items-end gap-2">
									<div class="d-form-control flex-1">
										<label class="label p-0 pb-1"><span class="label-text text-xs">Mata Uang</span></label>
										<select name="prices[0][currency]" class="d-select d-select-bordered d-select-sm w-full">
											<option value="IDR">IDR</option>
											<option value="USD">USD</option>
											<option value="SAR">SAR</option>
										</select>
									</div>
									<div class="d-form-control flex-1">
										<label class="label p-0 pb-1"><span class="label-text text-xs">Tipe</span></label>
										<input type="text" name="prices[0][price_type]" value="{{ old('prices[0][price_type]') }}" placeholder="Contoh: DOUBLE" class="d-input d-input-bordered d-input-sm w-full" />
									</div>
									<div class="d-form-control flex-1">
										<label class="label p-0 pb-1"><span class="label-text text-xs">Jumlah</span></label>
										<input type="number" name="prices[0][amount]" step="0.01" min="0" class="d-input d-input-bordered d-input-sm w-full" />
									</div>
									<button type="button" class="remove-price btn-ghost d-btn d-btn-square d-btn-sm text-error mb-0.5" disabled style="visibility:hidden">
										<x-lucide-x class="h-4 w-4" />
									</button>
								</div>
							</div>
							@error('prices')
								<span class="text-xs text-error mt-1">{{ $message }}</span>
							@enderror
						</div>
					</div>

					<div class="d-form-control w-full">
						<label class="label">
							<span class="label-text font-semibold">Termasuk (Inclusions)</span>
						</label>
						<textarea name="inclusions" rows="5" class="d-textarea d-textarea-bordered w-full text-sm">{{ old('inclusions', \App\Helpers\PreferenceHelper::get('package_inclusions_template')) }}</textarea>
						<div class="label">
							<span class="label-text-alt text-base-content/50">Pisahkan per baris</span>
						</div>
					</div>
					<div class="d-form-control w-full">
						<label class="label">
							<span class="label-text font-semibold">Tidak Termasuk (Exclusions)</span>
						</label>
						<textarea name="exclusions" rows="5" class="d-textarea d-textarea-bordered w-full text-sm">{{ old('exclusions', \App\Helpers\PreferenceHelper::get('package_exclusions_template')) }}</textarea>
						<div class="label">
							<span class="label-text-alt text-base-content/50">Pisahkan per baris</span>
						</div>
					</div>
					<div class="d-form-control w-full">
						<label class="label">
							<span class="label-text font-semibold">Persyaratan</span>
						</label>
						<textarea name="requirements" rows="5" class="d-textarea d-textarea-bordered w-full text-sm">{{ old('requirements', \App\Helpers\PreferenceHelper::get('package_requirements_template')) }}</textarea>
						<div class="label">
							<span class="label-text-alt text-base-content/50">Pisahkan per baris</span>
						</div>
					</div>

					<div class="pt-4 flex gap-2">
						<button type="submit" class="d-btn d-btn-primary">
							<x-lucide-save class="h-4 w-4 mr-2" />
							Simpan Paket
						</button>
						<a href="{{ route('admin.packages.index') }}" class="d-btn d-btn-ghost">Batal</a>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('priceRows');
        const addBtn = document.getElementById('addPriceRow');
        let idx = container.querySelectorAll('.price-row').length;

        addBtn.addEventListener('click', function() {
            const row = document.createElement('div');
            row.className = 'price-row flex items-end gap-2';
            row.innerHTML = '<div class="d-form-control flex-1">'
                + '<label class="label p-0 pb-1"><span class="label-text text-xs">Mata Uang</span></label>'
                + '<select name="prices[' + idx + '][currency]" class="d-select d-select-bordered d-select-sm w-full">'
                + '<option value="IDR">IDR</option><option value="USD">USD</option><option value="SAR">SAR</option>'
                + '</select></div>'
				+ '<div class="d-form-control flex-1">'
				+ '<label class="label"><span class="label-text text-xs">Tipe</span></label>'
				+ '<input type="text" name="prices[' + idx + '][price_type]" placeholder="Contoh: DOUBLE" class="d-input d-input-bordered d-input-sm w-full" />'
				+ '</div>'
                + '<div class="d-form-control flex-1">'
                + '<label class="label p-0 pb-1"><span class="label-text text-xs">Jumlah</span></label>'
                + '<input type="number" name="prices[' + idx + '][amount]" step="0.01" min="0" class="d-input d-input-bordered d-input-sm w-full" />'
                + '</div>'
                + '<button type="button" class="remove-price d-btn d-btn-square d-btn-ghost d-btn-sm text-error mb-0.5" title="Hapus">'
                + '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>'
                + '</button>';
            container.appendChild(row);
            idx++;

            row.querySelector('.remove-price').addEventListener('click', function() {
                row.remove();
            });
        });

        container.querySelectorAll('.remove-price').forEach(function(btn) {
            btn.addEventListener('click', function() {
                btn.closest('.price-row').remove();
            });
        });
    });
</script>
@endpush