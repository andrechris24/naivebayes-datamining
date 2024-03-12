<!DOCTYPE HTML>
<html data-bs-theme="auto">

<head>
	<title>
		@yield('title') | Aplikasi Klasifikasi Kelayakan Calon Penerima Bansos
	</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
		integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css"
		integrity="sha256-h2Gkn+H33lnKlQTNntQyLXMWq7/9XI2rlPCsLsVcUBs=" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
	<link
		href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.0/b-3.0.0/b-html5-3.0.0/r-3.0.0/datatables.min.css"
		rel="stylesheet">
	<link rel="stylesheet"
		href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/theme.css') }}">
	<script type="text/javascript" src="{{ asset('assets/js/theme.js') }}"></script>
	@yield('css')
</head>

<body onload="switchvalidation()">
	{{-- <x-theme /> --}}
	<header class="navbar sticky-top bg-dark flex-md-nowrap p-0 shadow" data-bs-theme="dark">
		<a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 text-white" href="{{ route('home') }}">
			Data Mining
		</a>
		<ul class="navbar-nav flex-row d-md-none">
			<li class="nav-item text-nowrap">
				<button class="nav-link px-3 text-white" type="button" data-bs-toggle="offcanvas"
					data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
					aria-label="Toggle navigation">
					<i class="bi bi-list"></i>
				</button>
			</li>
		</ul>
	</header>
	<div class="container-fluid">
		<div class="row">
			<div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
				<div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu"
					aria-labelledby="sidebarMenuLabel">
					<div class="offcanvas-header">
						<h5 class="offcanvas-title" id="sidebarMenuLabel">Data Mining</h5>
						<button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu"
							aria-label="Close"></button>
					</div>
					<div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
						<ul class="nav flex-column">
							<li class="nav-item">
								<a href="{{ route('home') }}" @class(['nav-link', 'd-flex',
								'align-items-center', 'gap-2', 'active'=> request()->is('/')])
									{{ request()->is('/') ? 'aria-current="page"' : '' }}>
									<i class="bi bi-house-fill"></i> Dashboard
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('atribut.index') }}" @class(['nav-link', 'd-flex',
								'align-items-center', 'gap-2', 'active'=> request()->is('atribut')])
									{{ request()->is('atribut') ? 'aria-current="page"' : '' }}>
									<i class="bi bi-file-earmark"></i> Atribut
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('atribut.nilai.index') }}" @class(['nav-link', 'd-flex',
								'align-items-center', 'gap-2', 'active'=> request()->is('atribut/nilai')])
									{{ request()->is('atribut/nilai') ? 'aria-current="page"' : '' }}>
									<i class="bi bi-file-earmark"></i> Nilai Atribut
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('training.index') }}" @class(['nav-link', 'd-flex',
								'align-items-center', 'gap-2', 'active'=> request()->is('training')])
									{{ request()->is('training') ? 'aria-current="page"' : '' }}>
									<i class="bi bi-file-earmark-text"></i> Data Training
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('testing.index') }}" @class(['nav-link', 'd-flex',
								'align-items-center', 'gap-2', 'active'=> request()->is('testing')])
									{{ request()->is('testing') ? 'aria-current="page"' : '' }}>
									<i class="bi bi-file-earmark-text"></i> Data Testing
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('probab.index') }}" @class(['nav-link', 'd-flex',
								'align-items-center', 'gap-2', 'active'=> request()->is('probab')])
									{{ request()->is('probab') ? 'aria-current="page"' : '' }}>
									<i class="bi bi-calculator"></i> Probabilitas
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('class.index') }}" @class(['nav-link', 'd-flex',
								'align-items-center', 'gap-2', 'active'=> request()->is('class')])
									{{ request()->is('class') ? 'aria-current="page"' : '' }}>
									<i class="bi bi-calculator"></i> Klasifikasi
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('result') }}" @class(['nav-link', 'd-flex',
								'align-items-center', 'gap-2', 'active'=> request()->is('performa')])
									{{ request()->is('performa') ? 'aria-current="page"' : '' }}>
									<i class="bi bi-graph-up"></i> Performa
								</a>
							</li>
						</ul>
						<hr class="my-3">
						<ul class="nav flex-column mb-auto">
							<li class="nav-item">
								<a href="{{ route('profil.edit') }}" @class(['nav-link', 'd-flex',
								'align-items-center', 'gap-2', 'active'=> request()->is('profile')])
									{{ request()->is('profile') ? 'aria-current="page"' : '' }}>
									<i class="bi bi-person-fill"></i> Profil
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link d-flex align-items-center gap-2" id="logout-btn"
									href="{{ route('logout') }}">
									<i class="bi bi-door-closed"></i> Log out
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
				<div
					class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
					<h2>@yield('title')</h2>
				</div>
				<x-alert />
				<x-no-script />
				@yield('content')
			</main>
			<footer class="py-3 my-4">
				<p class="text-center text-body-secondary">
					&copy; Copyright {{ date('Y') }} Data Mining
				</p>
			</footer>
		</div>
	</div>
	<form method="POST" id="logout-form" action="{{ route('logout') }}">@csrf</form>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
	</script>
	<script src="https://code.jquery.com/jquery-3.7.1.min.js"
		integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
	<script
		src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.0/b-3.0.0/b-html5-3.0.0/r-3.0.0/datatables.min.js">
	</script>
	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
	{{-- <script type="text/javascript" src="https://cdn.datatables.net/plug-ins/2.0.0/sorting/natural.js">
	</script> --}}
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script type="text/javascript" src="{{ asset('assets/js/swal.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/datatables.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/tooltip.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/validate.js') }}"></script>
	<script type="text/javascript">
		$(document).on('click', '#logout-btn', function (e) {
			e.preventDefault();
			document.getElementById('logout-form').submit();
		});
		function formloading(element, disable){
			$(element).prop('disabled',disable);
			$('.data-submit').prop('disabled',disable);
			if(disable) $('.spinner-grow').removeClass('d-none');
			else $('.spinner-grow').addClass('d-none');
		}
	</script>
	@yield('js')
</body>

</html>