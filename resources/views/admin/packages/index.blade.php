@extends('admin.layouts.main')

@section('title', 'Paket Perjalanan')

@section('breadcrumb')
	<li><a href="{{ route('admin') }}">Dashboard</a></li>
	<li>Paket Perjalanan</li>
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
					<h2 class="d-card-title font-display text-xl">Paket Perjalanan</h2>
					<p class="text-xs text-base-content/50">Kelola paket perjalanan umrah dan wisata.</p>
				</div>
				<a href="{{ route('admin.packages.create') }}" class="d-btn d-btn-primary d-btn-sm gap-2">
					<x-lucide-plus class="h-4 w-4" />
					Tambah Paket
				</a>
			</div>

			@if($packages->isEmpty())
				<div class="py-12 text-center">
					<x-lucide-package class="mx-auto h-12 w-12 text-base-content/30" />
					<p class="mt-2 text-sm text-base-content/50">Belum ada paket perjalanan.</p>
				</div>
			@else
				<div class="overflow-x-auto">
					<table class="d-table d-table-zebra">
						<thead>
							<tr>
								<th class="w-20">Flyer</th>
								<th>Paket</th>
								<th class="hidden lg:table-cell">Keberangkatan</th>
								<th class="hidden md:table-cell">Harga Mulai</th>
								<th class="hidden md:table-cell">Kuota</th>
								<th class="w-32 text-right">Aksi</th>
							</tr>
						</thead>
						<tbody>
							@foreach($packages as $package)
								<tr>
									<td>
										@if($package->flyer_path)
											<img src="{{ asset('storage/' . $package->flyer_path) }}" alt="{{ $package->title }}" class="h-14 w-20 object-cover rounded-lg border border-base-300 shadow-sm" />
										@else
											<div class="h-14 w-20 rounded-lg bg-base-200 flex items-center justify-center">
												<x-lucide-image class="h-5 w-5 text-base-content/30" />
											</div>
										@endif
									</td>
									<td>
										<span class="font-medium text-base-content">{{ $package->title }}</span>
										@if($package->category)
											<p class="text-xs text-base-content/50">{{ $package->category->name }}</p>
										@endif
									</td>
									<td class="hidden lg:table-cell text-xs">
										{{ \Carbon\Carbon::parse($package->date)->format('d M Y') }}
										<span class="block text-base-content/50">{{ $package->total_days }} hr</span>
									</td>
									<td class="hidden md:table-cell">
										@if($package->prices->isNotEmpty())
											<span class="font-display text-sm text-primary-700">
												{{ $package->prices->sortBy('price')->first()->currency }}
												{{ number_format($package->prices->sortBy('price')->first()->price, 0, ',', '.') }}
											</span>
										@else
											<span class="text-xs text-base-content/40">-</span>
										@endif
									</td>
									<td class="hidden md:table-cell">
										<span class="text-sm {{ $package->quota > 0 ? 'text-base-content' : 'text-error' }}">
											{{ $package->quota }}
										</span>
									</td>
									<td class="text-right">
										<div class="flex justify-end gap-2">
											<a href="{{ route('admin.packages.edit', $package) }}" class="d-btn d-btn-square d-btn-ghost d-btn-sm" title="Edit">
												<x-lucide-edit-3 class="h-4 w-4 text-info" />
											</a>
											<form action="{{ route('admin.packages.destroy', $package) }}" method="POST" onsubmit="return confirm('Hapus paket ini? Semua harga terkait akan ikut terhapus.')" class="inline-block">
												@csrf
												@method('DELETE')
												<button type="submit" class="d-btn d-btn-square d-btn-ghost d-btn-sm" title="Hapus">
													<x-lucide-trash-2 class="h-4 w-4 text-error" />
												</button>
											</form>
										</div>
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