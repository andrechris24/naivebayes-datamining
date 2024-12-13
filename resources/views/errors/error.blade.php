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

	<!-- Fontawesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

	<!-- Volt CSS -->
	<link type="text/css" href="{{asset('css/volt.css')}}" rel="stylesheet">

	<!-- Core -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
	</script>

	<!-- Vendor JS -->
	<script src="{{asset('assets/js/on-screen.umd.min.js')}}"></script>

	<!-- Slider -->
	<script src="{{asset('assets/js/nouislider.min.js')}}"></script>

	<!-- Smooth scroll -->
	<script src="{{asset('assets/js/smooth-scroll.polyfills.min.js')}}"></script>

	<!-- Volt JS -->
	<script src="{{asset('assets/js/volt.js')}}"></script>
</head>

<body>
	<section class="vh-100 d-flex align-items-center justify-content-center">
		<div class="container">@yield('content')</div>
	</section>
</body>

</html>