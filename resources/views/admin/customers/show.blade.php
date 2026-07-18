@extends('admin.layouts.main')

@section('title', $customer->name)

@section('breadcrumb')
	<li><a href="{{ route('admin') }}">Dashboard</a></li>
	<li><a href="{{ route('admin.customers.index') }}">Jamaah</a></li>
	<li>{{ $customer->name }}</li>
@endsection

@section('content')
	<div class="max-w-2xl">
		<div class="d-card bg-base-100 shadow-sm">
			<div class="d-card-body">
				<div class="flex items-center gap-4 mb-6">
					<div class="d-avatar">
						<div class="w-16 rounded-full ring ring-primary ring-offset-2 ring-offset-base-100">
							<img src="https://ui-avatars.com/api/?name={{ urlencode($customer->name) }}&background=f2c94c&color=050505&bold=true" alt="{{ $customer->name }}" />
						</div>
					</div>
					<div>
						<h2 class="d-card-title font-display text-xl">{{ $customer->name }}</h2>
						<p class="text-xs text-base-content/50">
							Bergabung {{ $customer->created_at->diffForHumans() }}
						</p>
					</div>
				</div>

				<div class="grid grid-cols-2 gap-4 text-sm">
					<div>
						<p class="text-xs text-base-content/50">Nama</p>
						<p class="font-medium">{{ $customer->name }}</p>
					</div>
					<div>
						<p class="text-xs text-base-content/50">Email</p>
						<p class="font-medium">{{ $customer->email }}</p>
					</div>
					<div>
						<p class="text-xs text-base-content/50">Telepon</p>
						<p class="font-medium">{{ $customer->phone ?? '-' }}</p>
					</div>
					<div>
						<p class="text-xs text-base-content/50">Jenis Kelamin</p>
						<p class="font-medium">{{ $customer->sex === 'male' ? 'Laki-laki' : 'Perempuan' }}</p>
					</div>
				</div>

				<div class="mt-6 pt-4 border-t border-base-300 text-xs text-base-content/50">
					<p>UUID: <code>{{ $customer->uuid }}</code></p>
					<p class="mt-1">ID: {{ $customer->id }}</p>
					<p class="mt-1">Terdaftar: {{ $customer->created_at->format('d M Y H:i') }}</p>
					@if($customer->updated_at !== $customer->created_at)
						<p class="mt-1">Diperbarui: {{ $customer->updated_at->format('d M Y H:i') }}</p>
					@endif
				</div>

				<div class="mt-6 flex gap-3">
					<a href="{{ route('admin.customers.edit', $customer) }}" class="d-btn d-btn-primary d-btn-sm">
						<x-lucide-edit-3 class="h-4 w-4" />
						Edit
					</a>
					<a href="{{ route('admin.customers.index') }}" class="d-btn d-btn-ghost d-btn-sm">Kembali</a>
				</div>
			</div>
		</div>
	</div>
@endsection