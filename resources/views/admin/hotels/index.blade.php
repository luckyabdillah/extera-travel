@extends('admin.layouts.main')

@section('title', 'Hotel')

@section('breadcrumb')
	<li><a href="{{ route('admin') }}">Dashboard</a></li>
	<li>Hotel</li>
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
					<h2 class="d-card-title font-display text-xl">Hotel</h2>
					<p class="text-xs text-base-content/50">Kelola data hotel untuk paket umrah & wisata.</p>
				</div>
				<a href="{{ route('admin.hotels.create') }}" class="d-btn d-btn-primary d-btn-sm gap-2">
					<x-lucide-plus class="h-4 w-4" />
					Tambah Hotel
				</a>
			</div>

			@if($hotels->isEmpty())
				<div class="py-12 text-center">
					<x-lucide-hotel class="mx-auto h-12 w-12 text-base-content/30" />
					<p class="mt-2 text-sm text-base-content/50">Belum ada data hotel.</p>
				</div>
			@else
				<div class="overflow-x-auto">
					<table class="d-table d-table-zebra">
						<thead>
							<tr>
								<th class="w-12">No</th>
								<th>Nama Hotel</th>
								<th class="hidden lg:table-cell">Kota</th>
								<th class="hidden lg:table-cell text-center w-24">Bintang</th>
								<th class="w-24 text-right">Aksi</th>
							</tr>
						</thead>
						<tbody>
							@foreach($hotels as $index => $hotel)
								<tr>
									<td class="text-base-content/50 text-sm">{{ $index + 1 }}</td>
									<td>
										<span class="font-medium text-base-content">{{ $hotel->name }}</span>
										<p class="text-xs text-base-content/50 lg:hidden">{{ ucwords(str_replace('-', ' ', $hotel->city)) }} &middot; {!! str_repeat('&#9733;', $hotel->star_rating) !!}</p>
									</td>
									<td class="hidden lg:table-cell text-sm">{{ ucwords(str_replace('-', ' ', $hotel->city)) }}</td>
									<td class="hidden lg:table-cell text-center">
										<span class="text-warning text-sm">{!! str_repeat('&#9733;', $hotel->star_rating) !!}</span>
									</td>
									<td class="text-right">
										<div class="flex justify-end gap-2">
											<a href="{{ route('admin.hotels.edit', $hotel) }}" class="d-btn d-btn-square d-btn-ghost d-btn-sm" title="Edit">
												<x-lucide-edit-3 class="h-4 w-4 text-info" />
											</a>
											<form action="{{ route('admin.hotels.destroy', $hotel) }}" method="POST" onsubmit="return confirm('Yakin hapus hotel ini?')" class="inline-block">
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
