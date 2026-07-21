@extends('admin.layouts.main')

@section('title', 'Transaksi Baru')

@section('breadcrumb')
	<li><a href="{{ route('admin') }}">Dashboard</a></li>
	<li><a href="{{ route('admin.transactions.index') }}">Transaksi</a></li>
	<li>Baru</li>
@endsection

@section('content')
	@if ($errors->any())
		<div class="d-alert d-alert-error mb-4 shadow-sm">
			<ul class="list-disc list-inside text-sm">
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	<div class="d-card bg-base-100 shadow-sm max-w-2xl">
		<div class="d-card-body">
			<h2 class="d-card-title font-display text-xl mb-6">Buat Transaksi Baru</h2>

			<form method="POST" action="{{ route('admin.transactions.store') }}" class="space-y-4">
				@csrf

				<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
					<div class="sm:col-span-2">
						<label class="d-label text-xs mb-1">
							<span>Nama Pemesan <span class="text-error">*</span></span>
						</label>
						<input type="text" name="name" value="{{ old('name') }}" class="d-input d-input-bordered w-full" required />
					</div>

					<div>
						<label class="d-label text-xs mb-1">
							<span>Email <span class="text-error">*</span></span>
						</label>
						<input type="email" name="email" value="{{ old('email') }}" class="d-input d-input-bordered w-full" required />
					</div>

					<div>
						<label class="d-label text-xs mb-1">
							<span>Telepon</span>
						</label>
						<input type="text" name="phone" value="{{ old('phone') }}" class="d-input d-input-bordered w-full" />
					</div>

					<div>
						<label class="d-label text-xs mb-1">
							<span>Paket (opsional)</span>
						</label>
						<select name="package_id" class="d-select d-select-bordered w-full">
							<option value="">Tanpa Paket</option>
							@foreach($packages as $pkg)
								<option value="{{ $pkg->id }}" @selected(old('package_id') == $pkg->id)>{{ $pkg->title }}</option>
							@endforeach
						</select>
					</div>

					<div>
						<label class="d-label text-xs mb-1">
							<span>Status <span class="text-error">*</span></span>
						</label>
						<select name="status" class="d-select d-select-bordered w-full" required>
							<option value="pending" @selected(old('status', 'pending') === 'pending')>Pending</option>
							<option value="confirmed" @selected(old('status') === 'confirmed')>Confirmed</option>
						</select>
					</div>

					<div>
						<label class="d-label text-xs mb-1">
							<span>Pembayaran <span class="text-error">*</span></span>
						</label>
						<select name="payment_status" class="d-select d-select-bordered w-full" required>
							<option value="unpaid" @selected(old('payment_status', 'unpaid') === 'unpaid')>Unpaid</option>
							<option value="paid" @selected(old('payment_status') === 'paid')>Paid</option>
						</select>
					</div>

					<div>
						<label class="d-label text-xs mb-1">
							<span>Tenggat Pembayaran (jam)</span>
						</label>
						<input type="number" name="expiration_time" value="{{ old('expiration_time', 24) }}" min="0" class="d-input d-input-bordered w-full" />
					</div>
				</div>

				<div class="flex gap-2 pt-4">
					<button type="submit" class="d-btn d-btn-primary">Buat Transaksi</button>
					<a href="{{ route('admin.transactions.index') }}" class="d-btn d-btn-ghost">Batal</a>
				</div>
			</form>
		</div>
	</div>
@endsection
