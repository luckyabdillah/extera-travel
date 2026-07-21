@extends("admin.layouts.main")

@section("title", "Laporan Keuangan " . $year)
@section("page-title", "Laporan Keuangan")

@section("breadcrumb")
	<li><a href="{{ route("admin") }}">Dashboard</a></li>
	<li>Laporan Keuangan</li>
@endsection

@section("content")
	<div class="mb-4">
		<div class="flex gap-2 justify-between items-center mb-2">
			<form method="GET" class="flex gap-2 items-center">
				<label class="text-sm font-semibold text-base-content/70">Tahun</label>
				<select name="year" onchange="this.form.submit()" class="d-select d-select-bordered d-select-sm w-28">
					@foreach($years as $y)
						<option value="{{ $y }}" @selected((int)$year === $y)>{{ $y }}</option>
					@endforeach
				</select>
			</form>
			<a href="{{ route('admin.reports.financial.pdf', ['year' => $year]) }}" target="_blank" class="d-btn d-btn-primary d-btn-sm gap-1.5">
				<x-lucide-file-text class="h-4 w-4" />
				Export PDF
			</a>
		</div>
		<p class="text-sm text-base-content/50">Ringkasan transaksi dan pendapatan.</p>
	</div>

	{{-- Summary Cards --}}
	<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-6">
		<div class="d-card bg-base-100 shadow-sm">
			<div class="d-card-body">
				<p class="text-xs font-semibold uppercase tracking-wide text-base-content/50">Total Pendapatan</p>
				<p class="font-display text-2xl text-success">Rp {{ number_format($totalRevenue, 0, ",", ".") }}</p>
				<p class="text-xs text-base-content/50">{{ $confirmedCount }} transaksi confirmed</p>
			</div>
		</div>
		<div class="d-card bg-base-100 shadow-sm">
			<div class="d-card-body">
				<p class="text-xs font-semibold uppercase tracking-wide text-base-content/50">Belum Dibayar</p>
				<p class="font-display text-2xl text-warning">Rp {{ number_format($totalUnpaid, 0, ",", ".") }}</p>
				<p class="text-xs text-base-content/50">{{ $pendingCount }} transaksi pending</p>
			</div>
		</div>
		<div class="d-card bg-base-100 shadow-sm">
			<div class="d-card-body">
				<p class="text-xs font-semibold uppercase tracking-wide text-base-content/50">Refund</p>
				<p class="font-display text-2xl text-error">Rp {{ number_format($totalRefund, 0, ",", ".") }}</p>
				<p class="text-xs text-base-content/50">Total dikembalikan</p>
			</div>
		</div>
		<div class="d-card bg-base-100 shadow-sm">
			<div class="d-card-body">
				<p class="text-xs font-semibold uppercase tracking-wide text-base-content/50">Total Transaksi</p>
				<p class="font-display text-2xl text-primary-700">{{ $totalTransactions }}</p>
				<p class="text-xs text-base-content/50">Tahun {{ $year }}</p>
			</div>
		</div>
	</div>

	<div class="grid gap-6 lg:grid-cols-3 mb-6">
		{{-- Revenue per Month --}}
		<div class="d-card bg-base-100 shadow-sm col-span-2 overflow-x-scroll">
			<div class="d-card-body">
				<h3 class="d-card-title font-display text-base mb-4">Pendapatan per Bulan</h3>
				<div class="overflow-x-auto">
					<table class="d-table d-table-zebra w-full text-sm">
						<thead>
							<tr>
								<th>Bulan</th>
								<th class="text-right text-success">Paid (Rp)</th>
								<th class="text-right text-warning">Unpaid (Rp)</th>
								<th class="text-right text-error">Refunded (Rp)</th>
								<th class="text-right font-bold">Total (Rp)</th>
							</tr>
						</thead>
						<tbody>
							@php($bulan = [1 => "Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"])
							@foreach($months as $m => $data)
								<tr>
									<td class="font-semibold">{{ $bulan[$m] }}</td>
									<td class="text-right text-success">{{ number_format($data["paid"], 0, ",", ".") }}</td>
									<td class="text-right text-warning">{{ number_format($data["unpaid"], 0, ",", ".") }}</td>
									<td class="text-right text-error">{{ number_format($data["refunded"], 0, ",", ".") }}</td>
									<td class="text-right font-bold">{{ number_format($data["paid"] + $data["unpaid"] + $data["refunded"], 0, ",", ".") }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>

		{{-- Revenue by Category --}}
		<div class="d-card bg-base-100 shadow-sm">
			<div class="d-card-body">
				<h3 class="d-card-title font-display text-base mb-4">Pendapatan per Kategori Paket</h3>
				@if($categoryRevenue->isEmpty())
					<p class="text-sm text-base-content/50 py-8 text-center">Belum ada data.</p>
				@else
					<div class="overflow-x-auto">
						<table class="d-table d-table-zebra w-full text-sm">
							<thead>
								<tr>
									<th>Kategori</th>
									<th class="text-right">Booking</th>
									<th class="text-right">Revenue (Rp)</th>
								</tr>
							</thead>
							<tbody>
								@foreach($categoryRevenue as $cr)
									<tr>
										<td class="font-semibold">{{ $cr->category ?? "Tanpa Kategori" }}</td>
										<td class="text-right">{{ $cr->bookings }}</td>
										<td class="text-right font-medium">{{ number_format($cr->revenue, 0, ",", ".") }}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				@endif
			</div>
		</div>
	</div>

	{{-- Top Packages --}}
	<div class="d-card bg-base-100 shadow-sm">
		<div class="d-card-body">
			<h3 class="d-card-title font-display text-base mb-4">Paket Terlaris (by Revenue)</h3>
			@if($topPackages->isEmpty())
				<p class="text-sm text-base-content/50 py-8 text-center">Belum ada data.</p>
			@else
				<div class="overflow-x-auto">
					<table class="d-table d-table-zebra w-full text-sm">
						<thead>
							<tr>
								<th>Paket</th>
								<th class="text-right">Booking</th>
								<th class="text-right">Revenue</th>
							</tr>
						</thead>
						<tbody>
							@foreach($topPackages as $tp)
								<tr>
									<td class="font-semibold">{{ $tp->package?->title ?? "Paket Dihapus" }}</td>
									<td class="text-right">{{ $tp->bookings }}</td>
									<td class="text-right font-medium">Rp {{ number_format($tp->revenue, 0, ",", ".") }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			@endif
		</div>
	</div>
@endsection