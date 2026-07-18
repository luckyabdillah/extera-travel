@extends('admin.layouts.main')

@section('title', 'Edit ' . $customer->name)

@section('breadcrumb')
	<li><a href="{{ route('admin') }}">Dashboard</a></li>
	<li><a href="{{ route('admin.customers.index') }}">Jamaah</a></li>
	<li><a href="{{ route('admin.customers.show', $customer) }}">{{ $customer->name }}</a></li>
	<li>Edit</li>
@endsection

@section('content')
	<div class="max-w-lg">
		<div class="d-card bg-base-100 shadow-sm">
			<div class="d-card-body">
				<h3 class="d-card-title font-display text-lg mb-4">Edit Data Jamaah</h3>

				<form method="POST" action="{{ route('admin.customers.update', $customer) }}" class="space-y-4">
					@csrf
					@method('PUT')

					<div>
						<label class="d-label text-sm mb-1">
							<span class="d-label-text">Nama Lengkap</span>
						</label>
						<input type="text" name="name" value="{{ old('name', $customer->name) }}"
							class="d-input d-input-bordered d-input-sm w-full @error('name') d-input-error @enderror" required />
						@error('name')
							<p class="mt-1 text-xs text-error">{{ $message }}</p>
						@enderror
					</div>

					<div>
						<label class="d-label text-sm mb-1">
							<span class="d-label-text">Email</span>
						</label>
						<input type="email" name="email" value="{{ old('email', $customer->email) }}"
							class="d-input d-input-bordered d-input-sm w-full @error('email') d-input-error @enderror" required />
						@error('email')
							<p class="mt-1 text-xs text-error">{{ $message }}</p>
						@enderror
					</div>

					<div>
						<label class="d-label text-sm mb-1">
							<span class="d-label-text">Telepon</span>
						</label>
						<input type="text" name="phone" value="{{ old('phone', $customer->phone) }}"
							class="d-input d-input-bordered d-input-sm w-full @error('phone') d-input-error @enderror" />
						@error('phone')
							<p class="mt-1 text-xs text-error">{{ $message }}</p>
						@enderror
					</div>

					<div>
						<label class="d-label text-sm mb-1">
							<span class="d-label-text">Jenis Kelamin</span>
						</label>
						<select name="sex" class="d-select d-select-bordered d-select-sm w-full @error('sex') d-select-error @enderror" required>
							<option value="male" @selected(old('sex', $customer->sex) === 'male')>Laki-laki</option>
							<option value="female" @selected(old('sex', $customer->sex) === 'female')>Perempuan</option>
						</select>
						@error('sex')
							<p class="mt-1 text-xs text-error">{{ $message }}</p>
						@enderror
					</div>

					<div class="flex gap-3 pt-2">
						<button type="submit" class="d-btn d-btn-primary d-btn-sm">Simpan</button>
						<a href="{{ route('admin.customers.show', $customer) }}" class="d-btn d-btn-ghost d-btn-sm">Batal</a>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection