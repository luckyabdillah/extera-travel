@extends('admin.layouts.main')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

	<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
		<div class="d-card bg-base-100 shadow-sm">
			<div class="d-card-body">
				<p class="text-xs font-semibold uppercase tracking-wide text-base-content/50">Total Jamaah</p>
				<p class="font-display text-3xl text-primary-700">1.284</p>
				<p class="text-xs text-success">+12% bulan ini</p>
			</div>
		</div>

		<div class="d-card bg-base-100 shadow-sm">
			<div class="d-card-body">
				<p class="text-xs font-semibold uppercase tracking-wide text-base-content/50">Booking Baru</p>
				<p class="font-display text-3xl text-primary-700">36</p>
				<p class="text-xs text-base-content/50">Minggu ini</p>
			</div>
		</div>

		<div class="d-card bg-base-100 shadow-sm">
			<div class="d-card-body">
				<p class="text-xs font-semibold uppercase tracking-wide text-base-content/50">Menunggu Konfirmasi</p>
				<p class="font-display text-3xl text-gold-600">8</p>
				<p class="text-xs text-base-content/50">Perlu ditindaklanjuti</p>
			</div>
		</div>

		<div class="d-card bg-base-100 shadow-sm">
			<div class="d-card-body">
				<p class="text-xs font-semibold uppercase tracking-wide text-base-content/50">Paket Aktif</p>
				<p class="font-display text-3xl text-primary-700">12</p>
				<p class="text-xs text-base-content/50">3 keberangkatan bulan ini</p>
			</div>
		</div>
	</div>

	<div class="d-card mt-6 bg-base-100 shadow-sm">
		<div class="d-card-body">
			<div class="mb-4 flex items-center justify-between">
				<h2 class="d-card-title font-display">Booking Terbaru</h2>
				<a href="#" class="d-btn d-btn-primary d-btn-sm">Lihat Semua</a>
			</div>

			<div class="overflow-x-auto">
				<table class="d-table">
					<thead>
						<tr>
							<th>Jamaah</th>
							<th>Paket</th>
							<th>Status</th>
							<th>Tanggal</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Rani Oktaviani</td>
							<td>Umrah Reguler</td>
							<td><span class="d-badge d-badge-success d-badge-sm">Lunas</span></td>
							<td>12 Jul 2026</td>
						</tr>
						<tr>
							<td>Fajar Ramadhan</td>
							<td>Umrah Plus Turki</td>
							<td><span class="d-badge d-badge-warning d-badge-sm">DP</span></td>
							<td>10 Jul 2026</td>
						</tr>
						<tr>
							<td>Nadia Salsabila</td>
							<td>Umrah Eksklusif</td>
							<td><span class="d-badge d-badge-ghost d-badge-sm">Menunggu</span></td>
							<td>09 Jul 2026</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>

@endsection