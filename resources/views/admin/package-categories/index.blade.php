@extends('admin.layouts.main')

@section('title', 'Kategori Paket')

@section('breadcrumb')
	<li><a href="{{ route('admin') }}">Dashboard</a></li>
	<li>Kategori Paket</li>
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
					<h2 class="d-card-title font-display text-xl">Kategori Paket</h2>
					<p class="text-xs text-base-content/50">Kelola kategori paket perjalanan.</p>
				</div>
				<a href="{{ route('admin.package-categories.create') }}" class="d-btn d-btn-primary d-btn-sm gap-2">
					<x-lucide-plus class="h-4 w-4" />
					Tambah Kategori
				</a>
			</div>

			@if($categories->isEmpty())
				<div class="py-12 text-center">
					<x-lucide-package class="mx-auto h-12 w-12 text-base-content/30" />
					<p class="mt-2 text-sm text-base-content/50">Belum ada kategori paket.</p>
				</div>
			@else
				<div class="overflow-x-auto">
					<table class="d-table d-table-zebra">
						<thead>
							<tr>
								<th class="w-24">Cover</th>
								<th>Nama</th>
								<th class="hidden sm:table-cell">Favorit</th>
								<th class="hidden sm:table-cell">Status</th>
								<th class="w-32 text-right">Aksi</th>
							</tr>
						</thead>
						<tbody>
							@foreach($categories as $category)
								<tr class="{{ $category->trashed() ? 'opacity-50' : '' }}">
									<td>
										@if($category->image_cover)
											<img src="{{ asset('storage/' . $category->image_cover) }}" alt="{{ $category->name }}" class="h-14 w-20 object-cover rounded-lg border border-base-300 shadow-sm" />
										@else
											<div class="h-14 w-20 rounded-lg bg-base-200 flex items-center justify-center">
												<x-lucide-image class="h-5 w-5 text-base-content/30" />
											</div>
										@endif
									</td>
									<td>
										<span class="font-medium text-base-content">{{ $category->name }}</span>
									</td>
									<td class="hidden sm:table-cell">
										@if($category->mark_as_favorite)
											<x-lucide-star class="h-4 w-4 text-gold-500" />
										@else
											<span class="text-xs text-base-content/40">-</span>
										@endif
									</td>
									<td class="hidden sm:table-cell">
										@if($category->trashed())
											<span class="d-badge d-badge-ghost d-badge-sm">Diarsipkan</span>
										@else
											<span class="d-badge d-badge-success d-badge-sm">Aktif</span>
										@endif
									</td>
									<td class="text-right">
										<div class="flex justify-end gap-2">
											@if($category->trashed())
												<a href="{{ route('admin.package-categories.restore', $category->uuid) }}" class="d-btn d-btn-square d-btn-ghost d-btn-sm" title="Pulihkan">
													<x-lucide-rotate-ccw class="h-4 w-4 text-success" />
												</a>
											@else
												<a href="{{ route('admin.package-categories.edit', $category) }}" class="d-btn d-btn-square d-btn-ghost d-btn-sm" title="Edit">
													<x-lucide-edit-3 class="h-4 w-4 text-info" />
												</a>
												<form action="{{ route('admin.package-categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Arsipkan kategori ini?')" class="inline-block">
													@csrf
													@method('DELETE')
													<button type="submit" class="d-btn d-btn-square d-btn-ghost d-btn-sm" title="Arsipkan">
														<x-lucide-archive class="h-4 w-4 text-warning" />
													</button>
												</form>
											@endif
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