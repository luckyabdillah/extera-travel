@extends('admin.layouts.main')

@section('title', 'Hero Images')

@section('breadcrumb')
	<li><a href="{{ route('admin') }}">Dashboard</a></li>
	<li>Hero Images</li>
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
					<h2 class="d-card-title font-display text-xl">Hero Images</h2>
					<p class="text-xs text-base-content/50">Kelola gambar yang tampil pada carousel landing page.</p>
				</div>
				<a href="{{ route('admin.hero-images.create') }}" class="d-btn d-btn-primary d-btn-sm gap-2">
					<x-lucide-plus class="h-4 w-4" />
					Tambah Hero Image
				</a>
			</div>

			@if($heroImages->isEmpty())
				<div class="py-12 text-center">
					<x-lucide-image class="mx-auto h-12 w-12 text-base-content/30" />
					<p class="mt-2 text-sm text-base-content/50">Belum ada hero image yang diunggah.</p>
					<p class="text-xs text-base-content/40 mt-1">Sistem akan menampilkan gambar default di landing page.</p>
				</div>
			@else
				<div class="overflow-x-auto">
					<table class="d-table d-table-zebra">
						<thead>
							<tr>
								<th class="w-32">Gambar</th>
								<th>Judul / Alt Text</th>
								<th>Tanggal Unggah</th>
								<th class="w-32 text-right">Aksi</th>
							</tr>
						</thead>
						<tbody>
							@foreach($heroImages as $hero)
								<tr>
									<td>
										<img src="{{ asset('storage/' . $hero->path) }}" alt="{{ $hero->title ?? 'Hero Image' }}" class="h-16 w-24 object-cover rounded-lg border border-base-300 shadow-sm" />
									</td>
									<td>
										<span class="font-medium text-base-content">{{ $hero->title ?? '-' }}</span>
									</td>
									<td>
										<span class="text-xs text-base-content/70">{{ $hero->created_at->format('d M Y, H:i') }}</span>
									</td>
									<td class="text-right">
										<div class="flex justify-end gap-2">
											<a href="{{ route('admin.hero-images.edit', $hero) }}" class="d-btn d-btn-square d-btn-ghost d-btn-sm" title="Edit">
												<x-lucide-edit-3 class="h-4 w-4 text-info" />
											</a>
											<form action="{{ route('admin.hero-images.destroy', $hero) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus gambar ini?')" class="inline-block">
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
