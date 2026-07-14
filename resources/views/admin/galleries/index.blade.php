@extends('admin.layouts.main')

@section('title', 'Galeri')

@section('breadcrumb')
	<li><a href="{{ route('admin') }}">Dashboard</a></li>
	<li>Galeri</li>
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
					<h2 class="d-card-title font-display text-xl">Galeri Foto</h2>
					<p class="text-xs text-base-content/50">Kelola foto-foto yang tampil di galeri landing page.</p>
				</div>
				<a href="{{ route('admin.galleries.create') }}" class="d-btn d-btn-primary d-btn-sm gap-2">
					<x-lucide-plus class="h-4 w-4" />
					Tambah Foto
				</a>
			</div>

			@if($galleries->isEmpty())
				<div class="py-12 text-center">
					<x-lucide-image class="mx-auto h-12 w-12 text-base-content/30" />
					<p class="mt-2 text-sm text-base-content/50">Belum ada foto galeri yang diunggah.</p>
				</div>
			@else
				<div class="overflow-x-auto">
					<table class="d-table d-table-zebra">
						<thead>
							<tr>
								<th class="w-28">Foto</th>
								<th>Judul</th>
								<th class="hidden md:table-cell">Deskripsi</th>
								<th class="w-32 text-right">Aksi</th>
							</tr>
						</thead>
						<tbody>
							@foreach($galleries as $gallery)
								<tr>
									<td>
										<img src="{{ asset('storage/' . $gallery->path) }}" alt="{{ $gallery->title ?? 'Gallery' }}" class="h-14 w-20 object-cover rounded-lg border border-base-300 shadow-sm" />
									</td>
									<td>
										<span class="font-medium text-base-content">{{ $gallery->title ?? '-' }}</span>
									</td>
									<td class="hidden md:table-cell">
										<span class="text-xs text-base-content/70">{{ Str::limit($gallery->description, 60) ?? '-' }}</span>
									</td>
									<td class="text-right">
										<div class="flex justify-end gap-2">
											<a href="{{ route('admin.galleries.edit', $gallery) }}" class="d-btn d-btn-square d-btn-ghost d-btn-sm" title="Edit">
												<x-lucide-edit-3 class="h-4 w-4 text-info" />
											</a>
											<form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto ini?')" class="inline-block">
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
