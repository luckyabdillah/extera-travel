@extends('admin.layouts.main')

@section('title', 'Jamaah')

@section('breadcrumb')
	<li><a href="{{ route('admin') }}">Dashboard</a></li>
	<li>Jamaah</li>
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
					<h2 class="d-card-title font-display text-xl">Data Jamaah</h2>
					<p class="text-xs text-base-content/50">Daftar seluruh jamaah yang pernah melakukan pemesanan.</p>
				</div>
				<div class="flex gap-2">
					<form method="GET" class="flex flex-wrap gap-2">
						<input type="text" name="search" placeholder="Cari nama, email, telepon..." value="{{ request('search') }}"
							class="d-input d-input-bordered d-input-sm w-44 lg:w-56" />
						<select name="sex" class="d-select d-select-bordered d-select-sm w-28">
							<option value="">Semua</option>
							<option value="male" @selected(request('sex') === 'male')>Laki-laki</option>
							<option value="female" @selected(request('sex') === 'female')>Perempuan</option>
						</select>
						<button type="submit" class="d-btn d-btn-primary d-btn-sm">Filter</button>
						@if(request()->anyFilled(['search', 'sex']))
							<a href="{{ route('admin.customers.index') }}" class="d-btn d-btn-ghost d-btn-sm">Reset</a>
						@endif
					</form>
				</div>
			</div>

			@if($customers->isEmpty())
				<div class="py-12 text-center">
					<x-lucide-users class="mx-auto h-12 w-12 text-base-content/30" />
					<p class="mt-2 text-sm text-base-content/50">Belum ada data jamaah.</p>
				</div>
			@else
				<div class="overflow-x-auto">
					<table class="d-table d-table-zebra">
						<thead>
							<tr>
								<th>Nama</th>
								<th class="hidden md:table-cell">Email</th>
								<th class="hidden lg:table-cell">Telepon</th>
								<th class="hidden lg:table-cell">Jenis Kelamin</th>
								<th class="hidden lg:table-cell">Bergabung</th>
								<th class="w-28 text-right">Aksi</th>
							</tr>
						</thead>
						<tbody>
							@foreach($customers as $c)
								<tr>
									<td>
										<span class="font-medium text-base-content">{{ $c->name }}</span>
									</td>
									<td class="hidden md:table-cell text-xs text-base-content/70">{{ $c->email }}</td>
									<td class="hidden lg:table-cell text-xs text-base-content/70">{{ $c->phone ?? '-' }}</td>
									<td class="hidden lg:table-cell">
										@if($c->sex === 'male')
											<span class="d-badge d-badge-info d-badge-sm">Laki-laki</span>
										@else
											<span class="d-badge d-badge-ghost d-badge-sm">Perempuan</span>
										@endif
									</td>
									<td class="hidden lg:table-cell text-xs text-base-content/70">
										{{ $c->created_at->format('d M Y') }}
									</td>
									<td class="text-right">
										<div class="flex justify-end gap-2">
											<a href="{{ route('admin.customers.show', $c) }}" class="d-btn d-btn-square d-btn-ghost d-btn-sm" title="Detail">
												<x-lucide-eye class="h-4 w-4 text-primary" />
											</a>
											<a href="{{ route('admin.customers.edit', $c) }}" class="d-btn d-btn-square d-btn-ghost d-btn-sm" title="Edit">
												<x-lucide-edit-3 class="h-4 w-4 text-info" />
											</a>
											<form action="{{ route('admin.customers.destroy', $c) }}" method="POST" onsubmit="return confirm('Hapus data jamaah ini?')" class="inline-block">
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

				<div class="mt-4">
					{{ $customers->links() }}
				</div>
			@endif
		</div>
	</div>
@endsection