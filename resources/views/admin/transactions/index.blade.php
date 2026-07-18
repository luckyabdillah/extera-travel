@extends('admin.layouts.main')

@section('title', 'Transaksi')

@section('breadcrumb')
	<li><a href="{{ route('admin') }}">Dashboard</a></li>
	<li>Transaksi</li>
@endsection

@section('content')
	@if(session('success'))
		<div class="d-alert d-alert-success mb-4 shadow-sm">
			<span>{{ session('success') }}</span>
		</div>
	@endif

	<div class="d-card bg-base-100 shadow-sm">
		<div class="d-card-body">
			<div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
				<div>
					<h2 class="d-card-title font-display text-xl">Pemesanan</h2>
					<p class="text-xs text-base-content/50">Daftar transaksi pemesanan paket umrah & wisata.</p>
				</div>
				<div class="flex gap-2">
					<form method="GET" class="flex flex-wrap gap-2">
						<input type="text" name="search" placeholder="Cari invoice, nama, email..." value="{{ request('search') }}"
							class="d-input d-input-bordered d-input-sm w-44 lg:w-56" />
						<select name="status" class="d-select d-select-bordered d-select-sm w-32">
							<option value="">Semua Status</option>
							<option value="pending" @selected(request('status') === 'pending')>Pending</option>
							<option value="confirmed" @selected(request('status') === 'confirmed')>Confirmed</option>
						</select>
						<select name="payment_status" class="d-select d-select-bordered d-select-sm w-36">
							<option value="">Semua Pembayaran</option>
							<option value="unpaid" @selected(request('payment_status') === 'unpaid')>Unpaid</option>
							<option value="paid" @selected(request('payment_status') === 'paid')>Paid</option>
						</select>
						<button type="submit" class="d-btn d-btn-primary d-btn-sm">Filter</button>
						@if(request()->anyFilled(['search', 'status', 'payment_status']))
							<a href="{{ route('admin.transactions.index') }}" class="d-btn d-btn-ghost d-btn-sm">Reset</a>
						@endif
					</form>
				</div>
			</div>

			@if($transactions->isEmpty())
				<div class="py-12 text-center">
					<x-lucide-scroll-text class="mx-auto h-12 w-12 text-base-content/30" />
					<p class="mt-2 text-sm text-base-content/50">Belum ada transaksi.</p>
				</div>
			@else
				<div class="overflow-x-auto">
					<table class="d-table d-table-zebra">
						<thead>
							<tr>
								<th>Invoice</th>
								<th>Nama Pemesan</th>
								<th class="hidden md:table-cell">Email</th>
								<th class="hidden lg:table-cell">Total</th>
								<th class="hidden lg:table-cell">Tanggal</th>
								<th>Status</th>
								<th>Pembayaran</th>
								<th class="w-20 text-right">Aksi</th>
							</tr>
						</thead>
						<tbody>
							@foreach($transactions as $t)
								<tr>
									<td>
										<span class="font-mono text-sm font-semibold text-base-content">#{{ $t->invoice_no }}</span>
									</td>
									<td>
										<span class="font-medium text-base-content">{{ $t->name }}</span>
										@if($t->phone)
											<p class="text-xs text-base-content/50">{{ $t->phone }}</p>
										@endif
									</td>
									<td class="hidden md:table-cell text-xs text-base-content/70">{{ $t->email }}</td>
									<td class="hidden lg:table-cell font-display text-sm">
										Rp {{ number_format($t->total_bill, 0, ',', '.') }}
									</td>
									<td class="hidden lg:table-cell text-xs text-base-content/70">
										{{ $t->created_at->format('d M Y') }}
									</td>
									<td>
										@if($t->status === 'confirmed')
											<span class="d-badge d-badge-success d-badge-sm">Confirmed</span>
										@else
											<span class="d-badge d-badge-ghost d-badge-sm">Pending</span>
										@endif
									</td>
									<td>
										@if($t->payment_status === 'paid')
											<span class="d-badge d-badge-success d-badge-sm">Paid</span>
										@else
											<span class="d-badge d-badge-warning d-badge-sm">Unpaid</span>
										@endif
									</td>
									<td class="text-right">
										<a href="{{ route('admin.transactions.show', $t) }}" class="d-btn d-btn-square d-btn-ghost d-btn-sm" title="Detail">
											<x-lucide-eye class="h-4 w-4 text-primary" />
										</a>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>

				<div class="mt-4">
					{{ $transactions->links() }}
				</div>
			@endif
		</div>
	</div>
@endsection