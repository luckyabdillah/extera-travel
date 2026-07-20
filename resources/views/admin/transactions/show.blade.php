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

	@if(session('error'))
		<div class="d-alert d-alert-error mb-4 shadow-sm">
			<span>{{ session('error') }}</span>
		</div>
	@endif

	@if ($errors->any())
		<div class="d-alert d-alert-error mb-4 shadow-sm">
			<ul class="list-disc list-inside text-sm">
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	<div class="grid gap-6 lg:grid-cols-3">
		{{-- Detail Transaksi --}}
		<div class="d-card bg-base-100 shadow-sm lg:col-span-2 min-w-0">
			<div class="d-card-body">
				<div class="flex items-center justify-between mb-4">
					<h3 class="d-card-title font-display text-lg">Detail Transaksi</h3>
					<div class="gap-2 hidden lg:flex">
						<a href="{{ route('admin.transactions.pdf', $transaction) }}" target="_blank" class="d-btn d-btn-primary d-btn-sm gap-1.5">
							<x-lucide-file-text class="h-4 w-4" />
							Invoice PDF
						</a>
						<a href="{{ route('admin.transactions.quotation-pdf', $transaction) }}" target="_blank" class="d-btn d-btn-secondary d-btn-sm gap-1.5">
							<x-lucide-file-text class="h-4 w-4" />
							Quotation PDF
						</a>
					</div>
					<div class="lg:hidden">
						<div class="d-dropdown d-dropdown-end">
							<div tabindex="0" role="button" class="d-btn d-btn-sm m-1">
								<x-lucide-file-text class="h-4 w-4" />
								PDF
							</div>
							<ul class="d-menu d-dropdown-content bg-base-100 rounded-box z-1 w-52 p-2 shadow-sm">
								<li><a href="{{ route('admin.transactions.pdf', $transaction) }}" target="_blank">Invoice PDF</a></li>
								<li><a href="{{ route('admin.transactions.quotation-pdf', $transaction) }}" target="_blank">Quotation PDF</a></li>
							</ul>
						</div>
					</div>
				</div>

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
							<span class="d-badge d-badge-error d-badge-sm">Pending</span>
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
								<th class="w-24 text-center">Aksi</th>
							</tr>
						</thead>
						<tbody>
							@forelse($transaction->details as $detail)
								@if(request('edit') == $detail->id)
									<tr>
										<td colspan="5">
											<form method="POST" action="{{ route('admin.transactions.details.update', [$transaction, $detail]) }}" class="flex flex-wrap items-end gap-2 py-1">
												@csrf
												@method('PATCH')
												<div class="flex-1 min-w-[150px]">
													<input type="text" name="description" value="{{ $detail->description }}" class="d-input d-input-bordered d-input-sm w-full" required />
												</div>
												<div class="w-20">
													<input type="number" name="qty" value="{{ $detail->qty }}" min="1" class="d-input d-input-bordered d-input-sm w-full text-center" required />
												</div>
												<div class="w-36">
													<input type="number" name="unit_price" value="{{ $detail->unit_price }}" min="0" step="0.01" class="d-input d-input-bordered d-input-sm w-full text-right" required />
												</div>
												<div class="flex gap-1">
													<button type="submit" class="d-btn d-btn-primary d-btn-sm" title="Simpan">
														<x-lucide-check class="h-4 w-4" />
													</button>
													<a href="{{ route('admin.transactions.show', $transaction) }}" class="d-btn d-btn-ghost d-btn-sm" title="Batal">
														<x-lucide-x class="h-4 w-4" />
													</a>
												</div>
											</form>
										</td>
									</tr>
								@else
									<tr>
										<td>{{ $detail->description }}</td>
										<td class="text-center">{{ $detail->qty }}</td>
										<td class="text-right">Rp {{ number_format($detail->unit_price, 0, ',', '.') }}</td>
										<td class="text-right font-semibold">Rp {{ number_format($detail->unit_price * $detail->qty, 0, ',', '.') }}</td>
										<td class="text-center">
											<div class="flex justify-center gap-1">
												<a href="{{ route('admin.transactions.show', $transaction) }}?edit={{ $detail->id }}" class="d-btn d-btn-square d-btn-ghost d-btn-xs" title="Edit">
													<x-lucide-pencil class="h-3 w-3 text-warning" />
												</a>
												<form method="POST" action="{{ route('admin.transactions.details.destroy', [$transaction, $detail]) }}" onsubmit="return confirm('Hapus item ini?')" class="inline">
													@csrf
													@method('DELETE')
													<button type="submit" class="d-btn d-btn-square d-btn-ghost d-btn-xs" title="Hapus">
														<x-lucide-trash-2 class="h-3 w-3 text-error" />
													</button>
												</form>
											</div>
										</td>
									</tr>
								@endif
							@empty
								<tr>
									<td colspan="5" class="text-center text-base-content/50 py-4">Tidak ada detail item.</td>
								</tr>
							@endforelse
						</tbody>
						<tfoot>
							<tr class="font-bold">
								<td colspan="4" class="text-right">Total</td>
								<td class="text-right text-primary-700">Rp {{ number_format($transaction->total_bill, 0, ',', '.') }}</td>
							</tr>
						</tfoot>
					</table>
				</div>

				{{-- Add Custom Item --}}
				<div class="mt-6 border-t border-base-300 pt-4">
					<h4 class="font-display text-base font-semibold mb-3">Tambah Item Kustom</h4>
					<form method="POST" action="{{ route('admin.transactions.details.store', $transaction) }}">
						@csrf
						<div class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-end">
							<div class="sm:col-span-5">
								<label class="d-label text-xs mb-1">
									<span>Deskripsi</span>
								</label>
								<input type="text" name="description" placeholder="Nama produk / layanan tambahan" class="d-input d-input-bordered d-input-sm w-full" required />
							</div>
							<div class="sm:col-span-2">
								<label class="d-label text-xs mb-1">
									<span>Qty</span>
								</label>
								<input type="number" name="qty" value="1" min="1" class="d-input d-input-bordered d-input-sm w-full text-center" required />
							</div>
							<div class="sm:col-span-3">
								<label class="d-label text-xs mb-1">
									<span>Harga Satuan (Rp)</span>
								</label>
								<input type="number" name="unit_price" value="0" min="0" step="1000" class="d-input d-input-bordered d-input-sm w-full text-right" required />
							</div>
							<div class="sm:col-span-2">
								<button type="submit" class="d-btn d-btn-secondary d-btn-sm w-full">
									<x-lucide-plus class="h-4 w-4 mr-1" /> Tambah
								</button>
							</div>
						</div>
					</form>
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
