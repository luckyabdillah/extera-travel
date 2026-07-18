@extends('admin.layouts.main')

@section('title', 'Transaksi #' . $transaction->invoice_no)
@section('page-title', '#' . $transaction->invoice_no)

@section('breadcrumb')
	<li><a href="{{ route('admin') }}">Dashboard</a></li>
	<li><a href="{{ route('admin.transactions.index') }}">Transaksi</a></li>
	<li>#{{ $transaction->invoice_no }}</li>
@endsection

@section('content')
	@if(session('success'))
		<div class="d-alert d-alert-success mb-4 shadow-sm">
			<span>{{ session('success') }}</span>
		</div>
	@endif

	<div class="grid gap-6 lg:grid-cols-3">
		{{-- Detail Transaksi --}}
		<div class="d-card bg-base-100 shadow-sm lg:col-span-2">
			<div class="d-card-body">
				<h3 class="d-card-title font-display text-lg mb-4">Detail Transaksi</h3>

				<div class="grid grid-cols-2 gap-4 text-sm">
					<div>
						<p class="text-xs text-base-content/50">Invoice</p>
						<p class="font-mono font-semibold">#{{ $transaction->invoice_no }}</p>
					</div>
					<div>
						<p class="text-xs text-base-content/50">Tanggal</p>
						<p>{{ $transaction->created_at->format('d M Y H:i') }}</p>
					</div>
					<div>
						<p class="text-xs text-base-content/50">Status</p>
						@if($transaction->status === 'confirmed')
							<span class="d-badge d-badge-success d-badge-sm">Confirmed</span>
						@else
							<span class="d-badge d-badge-ghost d-badge-sm">Pending</span>
						@endif
					</div>
					<div>
						<p class="text-xs text-base-content/50">Pembayaran</p>
						@if($transaction->payment_status === 'paid')
							<span class="d-badge d-badge-success d-badge-sm">Paid</span>
						@else
							<span class="d-badge d-badge-warning d-badge-sm">Unpaid</span>
						@endif
					</div>
					<div>
						<p class="text-xs text-base-content/50">Tenggat Pembayaran</p>
						<p>{{ $transaction->expiration_time }} jam sejak invoice</p>
					</div>
				</div>

				<h4 class="font-display text-base font-semibold mt-6 mb-3">Item Pesanan</h4>
				<div class="overflow-x-auto">
					<table class="d-table d-table-zebra w-full text-sm">
						<thead>
							<tr>
								<th>Deskripsi</th>
								<th class="text-center w-20">Qty</th>
								<th class="text-right w-36">Harga Satuan</th>
								<th class="text-right w-36">Subtotal</th>
							</tr>
						</thead>
						<tbody>
							@forelse($transaction->details as $detail)
								<tr>
									<td>{{ $detail->description }}</td>
									<td class="text-center">{{ $detail->qty }}</td>
									<td class="text-right">Rp {{ number_format($detail->unit_price, 0, ',', '.') }}</td>
									<td class="text-right font-semibold">Rp {{ number_format($detail->unit_price * $detail->qty, 0, ',', '.') }}</td>
								</tr>
							@empty
								<tr>
									<td colspan="4" class="text-center text-base-content/50 py-4">Tidak ada detail item.</td>
								</tr>
							@endforelse
						</tbody>
						<tfoot>
							<tr class="font-bold">
								<td colspan="3" class="text-right">Total</td>
								<td class="text-right text-primary-700">Rp {{ number_format($transaction->total_bill, 0, ',', '.') }}</td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>

		{{-- Info Pemesan & Aksi --}}
		<div class="space-y-6">
			<div class="d-card bg-base-100 shadow-sm">
				<div class="d-card-body">
					<h3 class="d-card-title font-display text-base mb-3">Info Pemesan</h3>

					<div class="space-y-3 text-sm">
						<div>
							<p class="text-xs text-base-content/50">Nama</p>
							<p class="font-medium">{{ $transaction->name }}</p>
						</div>
						<div>
							<p class="text-xs text-base-content/50">Email</p>
							<p class="font-medium">{{ $transaction->email }}</p>
						</div>
						@if($transaction->phone)
						<div>
							<p class="text-xs text-base-content/50">Telepon</p>
							<p class="font-medium">{{ $transaction->phone }}</p>
						</div>
						@endif
					</div>

					<div class="mt-4 text-xs text-base-content/50">
						<p>Invoice Year: {{ $transaction->invoice_year }}</p>
						<p>UUID: <code class="text-[10px]">{{ $transaction->uuid }}</code></p>
					</div>
				</div>
			</div>

			<div class="d-card bg-base-100 shadow-sm">
				<div class="d-card-body">
					<h3 class="d-card-title font-display text-base mb-3">Perbarui Status</h3>

					<form method="POST" action="{{ route('admin.transactions.update', $transaction) }}" class="space-y-3">
						@csrf
						@method('PATCH')

						<div>
							<label class="d-label text-xs mb-1">
								<span>Status Transaksi</span>
							</label>
							<select name="status" class="d-select d-select-bordered d-select-sm w-full">
								<option value="pending" @selected($transaction->status === 'pending')>Pending</option>
								<option value="confirmed" @selected($transaction->status === 'confirmed')>Confirmed</option>
							</select>
						</div>

						<div>
							<label class="d-label text-xs mb-1">
								<span>Status Pembayaran</span>
							</label>
							<select name="payment_status" class="d-select d-select-bordered d-select-sm w-full">
								<option value="unpaid" @selected($transaction->payment_status === 'unpaid')>Unpaid</option>
								<option value="paid" @selected($transaction->payment_status === 'paid')>Paid</option>
							</select>
						</div>

						<button type="submit" class="d-btn d-btn-primary d-btn-sm w-full">Simpan</button>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection