<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>@yield('title', 'Dashboard') — Extera Travel Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Reem+Kufi:wght@400;500;600;700&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,500&display=swap" rel="stylesheet">
        
	<!-- Icon -->
	<link rel="mask-icon" href="{{ asset('assets/img/logo/square-light.png') }}">
	<link rel="alternate icon" class="js-site-favicon" type="image/png" href="{{ asset('assets/img/logo/square-light.png') }}">
	<link rel="icon" class="js-site-favicon" type="image/png" href="{{ asset('assets/img/logo/square-light.png') }}">
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/logo/square-light.png') }}">
	<link rel="shortcut icon" href="{{ asset('assets/img/logo/square-light.png') }}" type="image/x-icon">

	{{-- Cegah flash tema saat reload kalau user pernah pilih dark mode --}}
	<script>
		(function () {
			const savedTheme = localStorage.getItem('admin-theme');
			if (savedTheme) document.documentElement.setAttribute('data-theme', savedTheme);
		})();
	</script>

	@vite(['resources/css/app.css', 'resources/js/app.js'])
	@stack('styles')
</head>

<body class="font-body min-h-screen bg-base-200 text-base-content">

	<div class="d-drawer lg:d-drawer-open">
		<input id="admin-drawer" type="checkbox" class="d-drawer-toggle" />

		{{-- Main content --}}
		<div class="d-drawer-content flex min-h-screen flex-col">
			@include('admin.partials.navbar')

			<main class="flex-1 p-4 lg:p-6">
				{{-- Breadcrumb slot, opsional --}}
				@hasSection('breadcrumb')
					<div class="d-breadcrumbs mb-4 text-sm">
						<ul>@yield('breadcrumb')</ul>
					</div>
				@endif

				@yield('content')
			</main>

			<footer class="border-t border-base-300 px-4 py-4 text-center text-xs text-base-content/50 lg:px-6">
				© {{ date('Y') }} Extera Travel. Admin Panel.
			</footer>
		</div>

		{{-- Sidebar --}}
		<div class="d-drawer-side z-40">
			<label for="admin-drawer" aria-label="Tutup sidebar" class="d-drawer-overlay"></label>
			@include('admin.partials.sidebar')
		</div>
	</div>

	@stack('scripts')
</body>
</html>