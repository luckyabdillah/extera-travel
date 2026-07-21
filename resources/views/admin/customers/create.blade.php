@extends("admin.layouts.main")

@section("title", "Tambah Jamaah")

@section("breadcrumb")
	<li><a href="{{ route("admin") }}">Dashboard</a></li>
	<li><a href="{{ route("admin.customers.index") }}">Jamaah</a></li>
	<li>Tambah</li>
@endsection

@section("content")
	<div class="max-w-lg">
		<div class="d-card bg-base-100 shadow-sm">
			<div class="d-card-body">
				<h3 class="d-card-title font-display text-lg mb-4">Tambah Jamaah Baru</h3>

				<form method="POST" action="{{ route("admin.customers.store") }}" class="space-y-4">
					@csrf

					<div>
						<label class="d-label text-sm mb-1">
							<span class="d-label-text">Nama Lengkap <span class="text-error">*</span></span>
						</label>
						<input type="text" name="name" value="{{ old("name") }}"
							class="d-input d-input-bordered d-input-sm w-full @error("name") d-input-error @enderror" required />
						@error("name")
							<p class="mt-1 text-xs text-error">{{ $message }}</p>
						@enderror
					</div>

					<div>
						<label class="d-label text-sm mb-1">
							<span class="d-label-text">Email <span class="text-error">*</span></span>
						</label>
						<input type="email" name="email" value="{{ old("email") }}"
							class="d-input d-input-bordered d-input-sm w-full @error("email") d-input-error @enderror" required />
						@error("email")
							<p class="mt-1 text-xs text-error">{{ $message }}</p>
						@enderror
					</div>

					<div>
						<label class="d-label text-sm mb-1">
							<span class="d-label-text">Telepon</span>
						</label>
						<input type="text" name="phone" value="{{ old("phone") }}"
							class="d-input d-input-bordered d-input-sm w-full @error("phone") d-input-error @enderror" />
						@error("phone")
							<p class="mt-1 text-xs text-error">{{ $message }}</p>
						@enderror
					</div>

					<div>
						<label class="d-label text-sm mb-1">
							<span class="d-label-text">Jenis Kelamin <span class="text-error">*</span></span>
						</label>
						<select name="sex" class="d-select d-select-bordered d-select-sm w-full @error("sex") d-select-error @enderror" required>
							<option value="">Pilih...</option>
							<option value="male" @selected(old("sex") === "male")>Laki-laki</option>
							<option value="female" @selected(old("sex") === "female")>Perempuan</option>
						</select>
						@error("sex")
							<p class="mt-1 text-xs text-error">{{ $message }}</p>
						@enderror
					</div>

					<div class="flex gap-3 pt-2">
						<button type="submit" class="d-btn d-btn-primary d-btn-sm">Simpan</button>
						<a href="{{ route("admin.customers.index") }}" class="d-btn d-btn-ghost d-btn-sm">Batal</a>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection