@extends('admin.layouts.main')

@section('title', 'Edit Paket')

@section('breadcrumb')
	<li><a href="{{ route('admin') }}">Dashboard</a></li>
	<li><a href="{{ route('admin.packages.index') }}">Paket Perjalanan</a></li>
	<li>Edit</li>
@endsection

@section('content')
	<div class="max-w-4xl">
		<div class="d-card bg-base-100 shadow-sm">
			<div class="d-card-body">
				<div class="mb-6 flex items-center justify-between">
					<div>
						<h2 class="d-card-title font-display text-xl">Edit Paket Perjalanan</h2>
					</div>
					<a href="{{ route('admin.packages.index') }}" class="d-btn d-btn-ghost d-btn-sm gap-2">
						<x-lucide-arrow-left class="h-4 w-4" />
						Kembali
					</a>
				</div>

				<form action="{{ route('admin.packages.update', $package) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
					@csrf
					@method('PUT')

					<div class="grid gap-4 sm:grid-cols-2">
						<div class="d-form-control w-full sm:col-span-2">
							<label class="label">
								<span class="label-text font-semibold">Judul Paket <span class="text-error">*</span></span>
							</label>
							<input type="text" name="title" value="{{ old('title', $package->title) }}" class="d-input d-input-bordered w-full" required />
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
									<option value="{{ $cat->id }}" {{ old('package_category_id', $package->package_category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
								@endforeach
							</select>
							@error('package_category_id')
								<span class="text-xs text-error mt-1">{{ $message }}</span>
							@enderror
						</div>

						<div class="d-form-control w-full">
							<label class="label">
								<span class="label-text font-semibold">Kuota <span class="text-error">*</span></span>
							</label>
							<input type="number" name="quota" value="{{ old('quota', $package->quota) }}" min="0" max="32767" class="d-input d-input-bordered w-full" required />
							@error('quota')
								<span class="text-xs text-error mt-1">{{ $message }}</span>
							@enderror
						</div>

						<div class="d-form-control w-full">
							<label class="label">
								<span class="label-text font-semibold">Tanggal Keberangkatan <span class="text-error">*</span></span>
							</label>
							<input type="date" name="date" value="{{ old('date', $package->date) }}" class="d-input d-input-bordered w-full" required />
							@error('date')
								<span class="text-xs text-error mt-1">{{ $message }}</span>
							@enderror
						</div>

						<div class="d-form-control w-full">
							<label class="label">
								<span class="label-text font-semibold">Lama Perjalanan (hari) <span class="text-error">*</span></span>
							</label>
							<input type="number" name="total_days" value="{{ old('total_days', $package->total_days) }}" min="1" max="255" class="d-input d-input-bordered w-full" required />
							@error('total_days')
								<span class="text-xs text-error mt-1">{{ $message }}</span>
							@enderror
						</div>

						<div class="d-form-control w-full sm:col-span-2">
							<label class="label">
								<span class="label-text font-semibold">Maskapai</span>
							</label>
							<input type="text" name="flight_by" value="{{ old('flight_by', $package->flight_by) }}" class="d-input d-input-bordered w-full" />
							@error('flight_by')
								<span class="text-xs text-error mt-1">{{ $message }}</span>
							@enderror
						</div>

						<div class="d-form-control w-full sm:col-span-2">
							<label class="label">
								<span class="label-text font-semibold">Flyer Saat Ini</span>
							</label>
							@if($package->flyer_path)
								<div class="mb-3 flex items-start gap-3">
									<img src="{{ asset('storage/' . $package->flyer_path) }}" alt="{{ $package->title }}" class="h-32 w-auto object-cover rounded-lg border border-base-300 shadow-sm" />
									<button type="button" onclick="if(confirm('Hapus flyer ini?')) document.getElementById('deleteFlyerForm').submit()" class="d-btn d-btn-square d-btn-ghost d-btn-sm text-error" title="Hapus Flyer">
										<x-lucide-trash-2 class="h-4 w-4" />
									</button>
								</div>
								<button type="button" onclick="document.getElementById('generateFlyerForm').submit()" class="d-btn d-btn-outline d-btn-primary d-btn-sm gap-1.5 mt-2 mb-3">
									<x-lucide-sparkles class="h-4 w-4" />
									Generate Flyer
								</button>
							@else
								<p class="text-sm text-base-content/50 mb-3">Belum ada flyer.</p>
								<button type="button" onclick="document.getElementById('generateFlyerForm').submit()" class="d-btn d-btn-outline d-btn-primary d-btn-sm gap-1.5 mb-3">
									<x-lucide-sparkles class="h-4 w-4" />
									Generate Flyer
								</button>
							@endif
							<label class="label block">
								<span class="label-text font-semibold">Ganti Flyer <span class="text-base-content/50">(Opsional)</span></span>
							</label>
							<input type="file" name="flyer_path" class="d-file-input d-file-input-bordered w-full" accept="image/*" />
							<div class="label">
								<span class="label-text-alt text-base-content/50">Kosongkan jika tidak ingin mengganti. Format: JPEG, PNG, JPG, WEBP, SVG. Maks 2MB.</span>
							</div>
							@error('flyer_path')
								<span class="text-xs text-error mt-1">{{ $message }}</span>
							@enderror
						</div>

						<div class="d-form-control w-full sm:col-span-2">
							<label class="label">
								<span class="label-text font-semibold">Itinerary PDF Saat Ini</span>
							</label>
							@if($package->itinerary_pdf)
								<div class="mb-3 flex items-center gap-2">
									<a href="{{ asset('storage/' . $package->itinerary_pdf) }}" target="_blank" class="d-btn d-btn-ghost d-btn-xs gap-1">
										<x-lucide-file-text class="h-4 w-4" />
										Lihat
									</a>
									<button type="button" onclick="if(confirm('Hapus itinerary PDF ini?')) document.getElementById('deleteItineraryPdfForm').submit()" class="d-btn d-btn-square d-btn-ghost d-btn-sm text-error" title="Hapus Itinerary PDF">
										<x-lucide-trash-2 class="h-4 w-4" />
									</button>
								</div>
							@else
								<p class="text-sm text-base-content/50 mb-3">Belum ada itinerary PDF.</p>
							@endif
							<!-- <label class="label">
								<span class="label-text font-semibold">Itinerary PDF</span>
							</label>
							@if($package->itinerary_pdf)
								<div class="mb-2 flex items-center gap-2">
									<a href="{{ asset("storage/" . $package->itinerary_pdf) }}" target="_blank" class="d-btn d-btn-ghost d-btn-xs gap-1">
										<x-lucide-file-text class="h-4 w-4" />
										Lihat PDF saat ini
									</a>
								</div>
							@endif -->
							<!-- <input type="file" name="itinerary_pdf" class="d-file-input d-file-input-bordered w-full" accept=".pdf,application/pdf" />
							<div class="label">
								<span class="label-text-alt text-base-content/50">Format: PDF. Maks 10MB. Biarkan kosong jika tidak ingin mengubah.</span>
							</div>
							@error("itinerary_pdf")
								<span class="text-xs text-error mt-1">{{ $message }}</span>
							@enderror -->
							<label class="label">
								<span class="label-text font-semibold">Ganti Itinerary PDF</span>
							</label>
							<input type="file" name="itinerary_pdf" class="d-file-input d-file-input-bordered w-full" accept=".pdf,application/pdf" />
							<div class="label">
								<span class="label-text-alt text-base-content/50">Kosongkan jika tidak ingin mengganti. Format: PDF. Maks 10MB.</span>
							</div>
							@error('itinerary_pdf')
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
                                @forelse($package->prices as $i => $price)
                                    <div class="price-row flex items-end gap-2">
                                        <div class="d-form-control flex-1">
                                            <label class="label p-0 pb-1"><span class="label-text text-xs">Mata Uang</span></label>
                                            <select name="prices[{{ $i }}][currency]" class="d-select d-select-bordered d-select-sm w-full">
                                                <option value="IDR" {{ $price->currency == 'IDR' ? 'selected' : '' }}>IDR</option>
                                                <option value="USD" {{ $price->currency == 'USD' ? 'selected' : '' }}>USD</option>
                                                <option value="SAR" {{ $price->currency == 'SAR' ? 'selected' : '' }}>SAR</option>
                                            </select>
                                        </div>
										<div class="d-form-control flex-1">
											<label class="label p-0 pb-1"><span class="label-text text-xs">Tipe</span></label>
											<input type="text" name="prices[{{ $i }}][price_type]" value="{{ $price->price_type }}" placeholder="Contoh: DOUBLE" class="d-input d-input-bordered d-input-sm w-full" />
										</div>
                                        <div class="d-form-control flex-1">
                                            <label class="label p-0 pb-1"><span class="label-text text-xs">Jumlah</span></label>
                                            <input type="number" name="prices[{{ $i }}][amount]" step="0.01" min="0" value="{{ $price->price }}" class="d-input d-input-bordered d-input-sm w-full" />
                                        </div>
                                        <button type="button" class="remove-price d-btn d-btn-square d-btn-ghost d-btn-sm text-error mb-0.5" title="Hapus">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                        </button>
                                    </div>
                                @empty
                                    <div class="price-row flex items-end gap-2">
                                        <div class="d-form-control flex-1">
                                            <label class="label p-0 pb-1"><span class="label-text text-xs">Mata Uang</span></label>
                                            <select name="prices[0][currency]" class="d-select d-select-bordered d-select-sm w-full">
                                                <option value="IDR">IDR</option>
                                                <option value="USD">USD</option>
                                                <option value="SAR">SAR</option>
                                            </select>
                                        </div>
                                        <div class="d-form-control flex-[2]">
                                            <label class="label p-0 pb-1"><span class="label-text text-xs">Jumlah</span></label>
                                            <input type="number" name="prices[0][amount]" step="0.01" min="0" class="d-input d-input-bordered d-input-sm w-full" />
                                        </div>
                                        <button type="button" class="remove-price d-btn d-btn-square d-btn-ghost d-btn-sm text-error mb-0.5" disabled style="visibility:hidden">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                        </button>
                                    </div>
                                @endforelse
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
						<textarea name="inclusions" rows="5" class="d-textarea d-textarea-bordered w-full text-sm">{{ old('inclusions', $package->inclusions) }}</textarea>
						<div class="label">
							<span class="label-text-alt text-base-content/50">Pisahkan per baris</span>
						</div>
					</div>
					<div class="d-form-control w-full">
						<label class="label">
							<span class="label-text font-semibold">Tidak Termasuk (Exclusions)</span>
						</label>
						<textarea name="exclusions" rows="5" class="d-textarea d-textarea-bordered w-full text-sm">{{ old('exclusions', $package->exclusions) }}</textarea>
						<div class="label">
							<span class="label-text-alt text-base-content/50">Pisahkan per baris</span>
						</div>
					</div>
					<div class="d-form-control w-full">
						<label class="label">
							<span class="label-text font-semibold">Persyaratan</span>
						</label>
						<textarea name="requirements" rows="5" class="d-textarea d-textarea-bordered w-full text-sm">{{ old('requirements', $package->requirements) }}</textarea>
						<div class="label">
							<span class="label-text-alt text-base-content/50">Pisahkan per baris</span>
						</div>
					</div>

					<div class="pt-4 flex gap-2">
						<button type="submit" class="d-btn d-btn-primary">
							<x-lucide-save class="h-4 w-4 mr-2" />
							Simpan Perubahan
						</button>
						<a href="{{ route('admin.packages.index') }}" class="d-btn d-btn-ghost">Batal</a>
					</div>
				</form>

				<form id="generateFlyerForm" action="{{ route('admin.packages.generate-flyer', $package) }}" method="POST" class="hidden">
					@csrf
				</form>

				<form id="deleteFlyerForm" action="{{ route('admin.packages.delete-flyer', $package) }}" method="POST" class="hidden">
					@csrf
					@method('DELETE')
				</form>

				<form id="deleteItineraryPdfForm" action="{{ route('admin.packages.delete-itinerary-pdf', $package) }}" method="POST" class="hidden">
					@csrf
					@method('DELETE')
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