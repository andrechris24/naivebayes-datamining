<!DOCTYPE html>
<html>

<head>
	<title>
		@yield('title') | Aplikasi Klasifikasi Kelayakan Calon Penerima Bansos
	</title>
	<!-- Favicons -->
	<link rel="apple-touch-icon" href="{{asset('assets/img/favicon/apple-touch-icon.png')}}" sizes="180x180">
	<link rel="icon" href="{{asset('assets/img/favicon/favicon-32x32.png')}}" sizes="32x32" type="image/png">
	<link rel="icon" href="{{asset('assets/img/favicon/favicon-16x16.png')}}" sizes="16x16" type="image/png">
	<link rel="mask-icon" href="{{asset('assets/img/favicon/safari-pinned-tab.svg')}}" color="#563d7c">
	<link rel="icon" href="{{asset('assets/img/favicon/favicon.ico')}}">
	<meta name="msapplication-config" content="{{asset('assets/img/favicons/browserconfig.xml')}}">
	<meta name="theme-color" content="#563d7c">
	<meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

	<!-- DataTables -->
	<link
		href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.0/b-3.0.0/b-html5-3.0.0/r-3.0.0/datatables.min.css"
		rel="stylesheet">

	<!-- Icons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
		integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
		crossorigin="anonymous" referrerpolicy="no-referrer" />

	<!-- Sweet Alert -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css"
		integrity="sha256-h2Gkn+H33lnKlQTNntQyLXMWq7/9XI2rlPCsLsVcUBs=" crossorigin="anonymous">

	<!-- Notyf -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

	<!-- Volt CSS -->
	<link type="text/css" href="{{asset('css/volt.css')}}" rel="stylesheet">

	<!-- Core -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
	</script>

	<!-- Vendor JS -->
	<script src="{{asset('assets/js/on-screen.umd.min.js')}}"></script>
	<script src="https://code.jquery.com/jquery-3.7.1.min.js"
		integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

	<!-- Slider -->
	<script src="{{asset('assets/js/nouislider.min.js')}}"></script>

	<!-- Smooth scroll -->
	<script src="{{asset('assets/js/smooth-scroll.polyfills.min.js')}}"></script>

	<!-- Apex Charts -->
	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

	<!-- Sweet Alerts 2 -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="https://cdn.jsdelivr.net/npm/notiflix@3.2.7/dist/notiflix-aio-3.2.7.min.js" integrity="sha256-G6sj3uSY1Rtnyomq54b5wiwwe2+A5Zym254DHutrXM4=" crossorigin="anonymous"></script>

	<!-- Notyf -->
	<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

	<!-- Data Tables -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
	<script
		src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.0/b-3.0.0/b-html5-3.0.0/r-3.0.0/datatables.min.js">
	</script>

	<!-- Simplebar -->
	<script src="https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.min.js"></script>

	<!-- Volt JS -->
	<script src="{{asset('assets/js/volt.js')}}"></script>
</head>

<body onload="switchvalidation()">
	<nav class="navbar navbar-dark navbar-theme-primary px-4 col-12 d-lg-none">
		<a class="navbar-brand me-lg-5" href="{{route('home')}}">
			<img class="navbar-brand-dark" src="{{asset('assets/img/data-mining_8438890.png')}}"
				alt="Data Mining logo" />
			<img class="navbar-brand-light" src="{{asset('assets/img/data-mining_8438890.png')}}"
				alt="Data Mining logo" />
		</a>
		<div class="d-flex align-items-center">
			<button class="navbar-toggler d-lg-none collapsed" type="button" data-bs-toggle="collapse"
				data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
				aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
		</div>
	</nav>
	<nav id="sidebarMenu" class="sidebar d-lg-block bg-gray-800 text-white collapse" data-simplebar>
		<div class="sidebar-inner px-2 pt-3">
			<div class="user-card d-flex align-items-center justify-content-between justify-content-lg-center pb-4">
				<div class="d-flex align-items-center">
					<div class="avatar-lg me-4">
						<img src="{{asset('assets/img/data-mining_8438890.png')}}" height="20" width="20" alt="Volt Logo">
					</div>
					<div class="d-block">
						<h2 class="h5 mb-3">Data Mining</h2>
					</div>
				</div>
				<div class="collapse-close d-md-none">
					<a href="#sidebarMenu" data-bs-toggle="collapse" data-bs-target="#sidebarMenu"
						aria-controls="sidebarMenu" aria-expanded="true" aria-label="Toggle navigation">
						<svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
							xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd"
								d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
								clip-rule="evenodd"></path>
						</svg>
					</a>
				</div>
			</div>
			<ul class="nav flex-column pt-3 pt-md-0">
				<li @class(['nav-item','active'=>Request::segment(1) == ''])>
					<a href="{{route('home')}}" class="nav-link">
						<span>
							<span class="sidebar-icon"><i class="fas fa-house"></i></span>
							<span class="sidebar-text">Dashboard</span>
						</span>
					</a>
				</li>
				<li @class(["nav-item",'active'=>Request::segment(1)=='atribut'&&empty(Request::segment(2))])>
					<a href="{{route('atribut.index')}}" class="nav-link d-flex justify-content-between">
						<span>
							<span class="sidebar-icon"><i class="fas fa-layer-group"></i></span>
							<span class="sidebar-text">Atribut</span>
						</span>
					</a>
				</li>
				<li @class(["nav-item", 'active'=>Request::segment(2) == 'nilai'])>
					<a href="{{route('atribut.nilai.index')}}" class="nav-link">
						<span>
							<span class="sidebar-icon"><i class="fas fa-layer-group"></i></span>
							<span class="sidebar-text">Nilai Atribut</span>
						</span>
					</a>
				</li>
				<li class="nav-item">
					<span @class(['nav-link','collapsed'=>in_array(request()->segment(1),['training','testing']),
						'd-flex','justify-content-between','align-items-center'])
						data-bs-toggle="collapse" data-bs-target="#submenu-dataset">
						<span>
							<span class="sidebar-icon"><i class="fas fa-database"></i></span>
							<span class="sidebar-text">Dataset</span>
						</span>
						<span class="link-arrow">
							<svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20"
								xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd"
									d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
									clip-rule="evenodd"></path>
							</svg>
						</span>
					</span>
					<div @class(["multi-level", "collapse" , 'show'=>
						in_array(request()->segment(1),['training','testing'])]) role="list"
						id="submenu-dataset" aria-expanded="false">
						<ul class="flex-column nav">
							<li @class(["nav-item", 'active'=> Request::segment(1) == 'training'])>
								<a class="nav-link" href="{{route('training.index')}}">
									<span class="sidebar-text">Data Training</span>
								</a>
							</li>
							<li @class(["nav-item", 'active'=> Request::segment(1) == 'testing'])>
								<a class="nav-link" href="{{route('testing.index')}}">
									<span class="sidebar-text">Data Testing</span>
								</a>
							</li>
						</ul>
					</div>
				</li>
				<li class="nav-item">
					<span @class(['nav-link','collapsed'=>in_array(request()->segment(1),['probab','class']),
						'd-flex','justify-content-between','align-items-center']) data-bs-toggle="collapse"
						data-bs-target="#submenu-naivebayes">
						<span>
							<span class="sidebar-icon"><i class="fas fa-calculator"></i></span>
							<span class="sidebar-text">Naive Bayes</span>
						</span>
						<span class="link-arrow">
							<svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20"
								xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd"
									d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
									clip-rule="evenodd"></path>
							</svg>
						</span>
					</span>
					<div @class(["multi-level", "collapse" , 'show'=>
						in_array(request()->segment(1),['probab','class'])])
						role="list" id="submenu-naivebayes" aria-expanded="false">
						<ul class="flex-column nav">
							<li @class(["nav-item", 'active'=> Request::segment(1) == 'probab'])>
								<a class="nav-link" href="{{ route('probab.index') }}">
									<span class="sidebar-text">Probabilitas</span>
								</a>
							</li>
							<li @class(["nav-item", 'active'=> Request::segment(1) == 'class'])>
								<a class="nav-link" href="{{route('class.index')}}">
									<span class="sidebar-text">Klasifikasi</span>
								</a>
							</li>
						</ul>
					</div>
				</li>
				<li @class(["nav-item",'active'=>request()->segment(1)=='result'])>
					<a href="{{route('result')}}" class="nav-link d-flex justify-content-between">
						<span>
							<span class="sidebar-icon"><i class="fas fa-chart-line"></i></span>
							<span class="sidebar-text">Performa</span>
						</span>
					</a>
				</li>
				<li role="separator" class="dropdown-divider mt-4 mb-3 border-gray-700"></li>
				<li class="nav-item">
					<a href="{{route('logout')}}" class="nav-link d-flex align-items-center" id="logout-btn">
						<span class="sidebar-icon">
							<svg class="icon icon-xxs me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
								xmlns="http://www.w3.org/2000/svg">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
									d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
								</path>
							</svg>
						</span>
						<span class="sidebar-text">Logout</span>
					</a>
				</li>
			</ul>
		</div>
	</nav>
	<main class="content">
		<nav class="navbar navbar-top navbar-expand navbar-dashboard navbar-dark ps-0 pe-2 pb-0">
			<div class="container-fluid px-0">
				<div class="d-flex justify-content-between w-100" id="navbarSupportedContent">
					<div class="d-flex align-items-center">
						<a href="{{route('phpinfo')}}" class="nav-item me-3">
							<i class="fa-brands fa-php fa-2x"></i>
						</a>
						<a href="{{route('laravel')}}" class="nav-item">
							<i class="fa-brands fa-laravel fa-2x"></i>
						</a>
					</div>
					<!-- Navbar links -->
					<ul class="navbar-nav align-items-center">
						<li class="nav-item dropdown ms-lg-3">
							<a class="nav-link dropdown-toggle pt-1 px-0" href="#" role="button" data-bs-toggle="dropdown"
								aria-expanded="false">
								<div class="media d-flex align-items-center">
									{{-- <img class="avatar rounded-circle" alt="Image placeholder"
										src="{{asset('assets/img/team/profile-picture-1.jpg')}}"> --}}
									<div class="media-body ms-2 text-dark align-items-center">
										<span class="mb-0 font-small fw-bold text-gray-900">
											{{auth()->user()->name}}
										</span>
									</div>
								</div>
							</a>
							<div class="dropdown-menu dashboard-dropdown dropdown-menu-end mt-2 py-1">
								<a class="dropdown-item d-flex align-items-center" href="{{route('profil.index')}}">
									<svg class="dropdown-icon text-gray-400 me-2" fill="currentColor" viewBox="0 0 20 20"
										xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd"
											d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
											clip-rule="evenodd"></path>
									</svg>
									Profil
								</a>
								<div role="separator" class="dropdown-divider my-1"></div>
								<a class="dropdown-item d-flex align-items-center" href="{{route('logout')}}" id="logout-btn">
									<svg class="icon icon-xxs me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
										xmlns="http://www.w3.org/2000/svg">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
										</path>
									</svg>Logout
								</a>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<h2 class="h4">@yield('title')</h2>
		<x-alert />
		<x-no-script />
		@yield('content')
		<footer class="bg-white rounded shadow p-5 mb-4 mt-4">
			<div class="row">
				<div class="col-12 col-md-4 col-xl-6 mb-4 mb-md-0">
					<p class="mb-0 text-center text-lg-start">
						© <span class="current-year"></span> Naive Bayes Data Mining
					</p>
				</div>
				<div class="col-12 col-md-8 col-xl-6 text-center text-lg-start">
					Template oleh <a class="text-primary fw-normal" href="https://themesberg.com"
						target="_blank">Themesberg</a> & <a href="https://updivision.com/" target="_blank">Updivision</a>
				</div>
			</div>
		</footer>
	</main>
	<form method="POST" id="logout-form" action="{{ route('logout') }}">@csrf</form>
	<script type="text/javascript" src="{{ asset('assets/js/swal.js') }}"></script>
	<script type="text/javascript" src="{{asset('assets/js/notyf.js')}}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/datatables.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/validate.js') }}"></script>
	<script type="text/javascript">
		$(document).on('click', '#logout-btn', function (e) {
			e.preventDefault();
			document.getElementById('logout-form').submit();
		});
		function formloading(formEl, disable){
			$(formEl).prop('disabled', disable);
			if(disable) $('.spinner-grow').removeClass('d-none');
			else $('.spinner-grow').addClass('d-none');
		}
	</script>
	@yield('js')
</body>

</html>