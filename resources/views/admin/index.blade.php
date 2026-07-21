@extends('admin.layouts.main')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

	<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
		<div class="d-card bg-base-100 shadow-sm">
			<div class="d-card-body">
				<p class="text-xs font-semibold uppercase tracking-wide text-base-content/50">Total Jamaah</p>
				<p class="font-display text-3xl text-primary-700">{{ number_format($totalJamaah, 0, ',', '.') }}</p>
				<p class="text-xs text-base-content/50">Terdaftar</p>
			</div>
		</div>

		<div class="d-card bg-base-100 shadow-sm">
			<div class="d-card-body">
				<p class="text-xs font-semibold uppercase tracking-wide text-base-content/50">Booking Baru</p>
				<p class="font-display text-3xl text-primary-700">{{ $bookingBaru }}</p>
				<p class="text-xs text-base-content/50">Minggu ini</p>
			</div>
		</div>

		<div class="d-card bg-base-100 shadow-sm">
			<div class="d-card-body">
				<p class="text-xs font-semibold uppercase tracking-wide text-base-content/50">Menunggu Konfirmasi</p>
				<p class="font-display text-3xl text-gold-600">{{ $menungguKonfirmasi }}</p>
				<p class="text-xs text-base-content/50">Perlu ditindaklanjuti</p>
			</div>
		</div>

		<div class="d-card bg-base-100 shadow-sm">
			<div class="d-card-body">
				<p class="text-xs font-semibold uppercase tracking-wide text-base-content/50">Paket Aktif</p>
				<p class="font-display text-3xl text-primary-700">{{ $paketAktif }}</p>
				<p class="text-xs text-base-content/50">Tersedia</p>
			</div>
		</div>
	</div>

	<div class="d-card mt-6 bg-base-100 shadow-sm">
		<div class="d-card-body">
			<div class="mb-4 flex items-center justify-between">
				<h2 class="d-card-title font-display">Booking Terbaru</h2>
				<a href="{{ route('admin.transactions.index') }}" class="d-btn d-btn-primary d-btn-sm">Lihat Semua</a>
			</div>

			@if($bookingTerbaru->isEmpty())
				<div class="py-12 text-center">
					<x-lucide-scroll-text class="mx-auto h-12 w-12 text-base-content/30" />
					<p class="mt-2 text-sm text-base-content/50">Belum ada booking.</p>
				</div>
			@else
				<div class="overflow-x-auto">
					<table class="d-table d-table-zebra">
						<thead>
							<tr>
								<th>Invoice</th>
								<th>Jamaah</th>
								<th>Paket</th>
								<th>Status</th>
								<th>Tanggal</th>
							</tr>
						</thead>
						<tbody>
							@foreach($bookingTerbaru as $trx)
								<tr>
									<td>
										<a href="{{ route('admin.transactions.show', $trx) }}" class="font-mono text-xs font-semibold text-primary-600 hover:underline">
											{{ $trx->invoice_no }}
										</a>
									</td>
									<td>
										<span class="font-medium">{{ $trx->name }}</span>
									</td>
									<td>
										<span class="text-sm">{{ $trx->package?->title ?? '-' }}</span>
									</td>
									<td>
										@if($trx->status === 'confirmed')
											<span class="d-badge d-badge-success d-badge-sm">Confirmed</span>
										@else
											<span class="d-badge d-badge-warning d-badge-sm">Pending</span>
										@endif
									</td>
									<td>
										<span class="text-xs text-base-content/50">{{ $trx->created_at->format('d M Y') }}</span>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			@endif
		</div>
	</div>

@endsection