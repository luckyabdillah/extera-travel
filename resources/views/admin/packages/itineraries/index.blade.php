@extends('admin.layouts.main')

@section('title', 'Itinerary - ' . $package->title)

@section('breadcrumb')
	<li><a href="{{ route('admin') }}">Dashboard</a></li>
	<li><a href="{{ route('admin.packages.index') }}">Paket</a></li>
	<li>{{ $package->title }}</li>
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
					<h2 class="d-card-title font-display text-xl">Itinerary</h2>
					<p class="text-xs text-base-content/50">Kelola jadwal perjalanan paket ini.</p>
				</div>
				<a href="{{ route('admin.packages.itineraries.create', $package) }}" class="d-btn d-btn-primary d-btn-sm gap-2">
					<x-lucide-plus class="h-4 w-4" />
					Tambah Hari
				</a>
			</div>

			@if($itineraries->isEmpty())
				<div class="py-12 text-center">
					<x-lucide-map-pin class="mx-auto h-12 w-12 text-base-content/30" />
					<p class="mt-2 text-sm text-base-content/50">Belum ada itinerary untuk paket ini.</p>
				</div>
			@else
				<div class="space-y-3">
					@foreach($itineraries as $it)
						<div class="rounded-2xl border border-primary-200 bg-white p-5 shadow-sm">
							<div class="flex items-start justify-between gap-4">
								<div>
									<div class="flex items-center gap-3">
										<span class="d-badge d-badge-primary d-badge-sm font-bold">{{ $it->marker }}</span>
										<h3 class="font-display text-base text-ink-900">{{ $it->title }}</h3>
									</div>
									<p class="mt-2 text-sm text-ink-600 whitespace-pre-line">{{ Str::limit($it->itinerary, 200) }}</p>
									@if($it->accommodation_place || $it->meals)
										<div class="mt-3 flex flex-wrap gap-x-4 gap-y-1 text-xs text-ink-500">
											@if($it->accommodation_place)
												<span>{{ $it->accommodation_place }} @if($it->accommodation_days)({{ $it->accommodation_days }} malam)@endif</span>
											@endif
											@if($it->meals)
												<span>{{ $it->meals }}</span>
											@endif
										</div>
									@endif
								</div>
								<div class="flex gap-2 shrink-0">
									<a href="{{ route('admin.packages.itineraries.edit', [$package, $it]) }}" class="d-btn d-btn-square d-btn-ghost d-btn-sm" title="Edit">
										<x-lucide-edit-3 class="h-4 w-4 text-info" />
									</a>
									<form action="{{ route('admin.packages.itineraries.destroy', [$package, $it]) }}" method="POST" onsubmit="return confirm('Hapus itinerary ini?')" class="inline-block">
										@csrf @method('DELETE')
										<button type="submit" class="d-btn d-btn-square d-btn-ghost d-btn-sm" title="Hapus">
											<x-lucide-trash-2 class="h-4 w-4 text-error" />
										</button>
									</form>
								</div>
							</div>
						</div>
					@endforeach
				</div>
			@endif

			<div class="mt-6">
				<a href="{{ route('admin.packages.index') }}" class="d-btn d-btn-ghost d-btn-sm gap-2">
					<x-lucide-arrow-left class="h-4 w-4" />
					Kembali ke Paket
				</a>
			</div>
		</div>
	</div>
@endsection