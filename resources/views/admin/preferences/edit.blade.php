@extends('admin.layouts.main')

@section('title', 'Preferensi')

@section('breadcrumb')
	<li><a href="{{ route('admin') }}">Dashboard</a></li>
	<li>Pengaturan</li>
	<li>Preferensi</li>
@endsection

@section('content')
	@if(session('success'))
		<div class="d-alert d-alert-success mb-4 shadow-sm">
			<span>{{ session('success') }}</span>
		</div>
	@endif

	<form action="{{ route('admin.settings.preferences.update') }}" method="POST">
		@csrf
		@method('PUT')

		<div class="grid gap-6 lg:grid-cols-2">
			{{-- System --}}
			<div class="d-card bg-base-100 shadow-sm">
				<div class="d-card-body">
					<h2 class="d-card-title font-display text-lg">Sistem</h2>
					<p class="text-xs text-base-content/50">Email info yang digunakan untuk pengiriman notifikasi.</p>

					<div class="d-form-control w-full">
						<label class="label">
							<span class="label-text font-semibold">Mail Info <span class="text-error">*</span></span>
						</label>
						<input type="email" name="mail_info" value="{{ old('mail_info', $preferences['mail_info'] ?? '') }}" class="d-input d-input-bordered w-full" placeholder="info@exteratravel.com" required />
						@error('mail_info')
							<span class="text-xs text-error mt-1">{{ $message }}</span>
						@enderror
					</div>
					<div class="mt-4 space-y-4">
					</div>
				</div>
			</div>

			{{-- Kontak --}}
			<div class="d-card bg-base-100 shadow-sm">
				<div class="d-card-body">
					<h2 class="d-card-title font-display text-lg">Kontak</h2>
					<p class="text-xs text-base-content/50">Nomor WhatsApp, email kontak, dan alamat kantor.</p>

					<div class="mt-4 space-y-4">
						<div class="d-form-control w-full">
							<label class="label">
								<span class="label-text font-semibold">WhatsApp <span class="text-error">*</span></span>
							</label>
							<input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $preferences['whatsapp_number'] ?? '') }}" class="d-input d-input-bordered w-full" placeholder="+62812 3456 7890" required />
							@error('whatsapp_number')
								<span class="text-xs text-error mt-1">{{ $message }}</span>
							@enderror
						</div>

						<div class="d-form-control w-full">
							<label class="label">
								<span class="label-text font-semibold">Email <span class="text-error">*</span></span>
							</label>
							<input type="email" name="email" value="{{ old('email', $preferences['email'] ?? '') }}" class="d-input d-input-bordered w-full" placeholder="hello@exteratravel.com" required />
							@error('email')
								<span class="text-xs text-error mt-1">{{ $message }}</span>
							@enderror
						</div>

						<div class="d-form-control w-full">
							<label class="label">
								<span class="label-text font-semibold">Alamat <span class="text-error">*</span></span>
							</label>
							<textarea name="address" rows="3" class="d-textarea d-textarea-bordered w-full" placeholder="Jl. Sudirman No. 123, Jakarta" required>{{ old('address', $preferences['address'] ?? '') }}</textarea>
							@error('address')
								<span class="text-xs text-error mt-1">{{ $message }}</span>
							@enderror
						</div>
					</div>
				</div>
			</div>

			{{-- Media Sosial --}}
			<div class="d-card bg-base-100 shadow-sm lg:col-span-2">
				<div class="d-card-body">
					<h2 class="d-card-title font-display text-lg">Media Sosial</h2>
					<p class="text-xs text-base-content/50">Akun media sosial perusahaan (opsional).</p>

					<div class="mt-4 grid gap-4 sm:grid-cols-3">
						<div class="d-form-control w-full">
							<label class="label">
								<span class="label-text font-semibold">Facebook</span>
							</label>
							<input type="text" name="facebook_account" value="{{ old('facebook_account', $preferences['facebook_account'] ?? '') }}" class="d-input d-input-bordered w-full" placeholder="https://facebook.com/exteratravel" />
							@error('facebook_account')
								<span class="text-xs text-error mt-1">{{ $message }}</span>
							@enderror
						</div>

						<div class="d-form-control w-full">
							<label class="label">
								<span class="label-text font-semibold">Instagram</span>
							</label>
							<input type="text" name="instagram_account" value="{{ old('instagram_account', $preferences['instagram_account'] ?? '') }}" class="d-input d-input-bordered w-full" placeholder="https://instagram.com/exteratravel" />
							@error('instagram_account')
								<span class="text-xs text-error mt-1">{{ $message }}</span>
							@enderror
						</div>

						<div class="d-form-control w-full">
							<label class="label">
								<span class="label-text font-semibold">TikTok</span>
							</label>
							<input type="text" name="tiktok_account" value="{{ old('tiktok_account', $preferences['tiktok_account'] ?? '') }}" class="d-input d-input-bordered w-full" placeholder="k" />
							@error('tiktok_account')
								<span class="text-xs text-error mt-1">{{ $message }}</span>
							@enderror
						</div>
					</div>
				</div>
			</div>

			{{-- Template Paket --}}
			<div class="d-card bg-base-100 shadow-sm lg:col-span-2">
				<div class="d-card-body">
					<h2 class="d-card-title font-display text-lg">Template Paket</h2>
					<p class="text-xs text-base-content/50">Template default untuk inklusi, eksklusi, dan persyaratan paket. Satu item per baris.</p>

					<div class="mt-4 grid gap-4 lg:grid-cols-3">
						<div class="d-form-control w-full">
							<label class="label">
								<span class="label-text font-semibold">Inklusi</span>
							</label>
							<textarea name="package_inclusions_template" rows="8" class="d-textarea d-textarea-bordered w-full text-sm" placeholder="Tiket pesawat PP&#10;Hotel bintang 4 dekat Masjidil Haram&#10;...">{{ old('package_inclusions_template', $preferences['package_inclusions_template'] ?? '') }}</textarea>
							@error('package_inclusions_template')
								<span class="text-xs text-error mt-1">{{ $message }}</span>
							@enderror
						</div>

						<div class="d-form-control w-full">
							<label class="label">
								<span class="label-text font-semibold">Eksklusi</span>
							</label>
							<textarea name="package_exclusions_template" rows="8" class="d-textarea d-textarea-bordered w-full text-sm" placeholder="Biaya visa tambahan&#10;Biaya kelebihan bagasi&#10;...">{{ old('package_exclusions_template', $preferences['package_exclusions_template'] ?? '') }}</textarea>
							@error('package_exclusions_template')
								<span class="text-xs text-error mt-1">{{ $message }}</span>
							@enderror
						</div>

						<div class="d-form-control w-full">
							<label class="label">
								<span class="label-text font-semibold">Persyaratan</span>
							</label>
							<textarea name="package_requirements_template" rows="8" class="d-textarea d-textarea-bordered w-full text-sm" placeholder="Paspor masa berlaku min 12 bulan&#10;KTP asli dan fotokopi&#10;...">{{ old('package_requirements_template', $preferences['package_requirements_template'] ?? '') }}</textarea>
							@error('package_requirements_template')
								<span class="text-xs text-error mt-1">{{ $message }}</span>
							@enderror
						</div>
					</div>
				</div>
			</div>
		</div>

		{{-- Submit --}}
		<div class="mt-6 flex gap-2">
			<button type="submit" class="d-btn d-btn-primary">
				<x-lucide-save class="h-4 w-4 mr-2" />
				Simpan Perubahan
			</button>
			<a href="{{ route('admin') }}" class="d-btn d-btn-ghost">Kembali</a>
		</div>
	</form>
@endsection