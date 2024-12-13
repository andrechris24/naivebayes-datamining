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

	<!-- Vendor CSS -->
	{{--
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	--}}

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
	<script src="https://code.jquery.com/jquery-3.7.1.min.js"
		integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

	<!-- Smooth scroll -->
	<script src="{{asset('assets/js/smooth-scroll.polyfills.min.js')}}"></script>

	<!-- Volt JS -->
	<script src="{{asset('assets/js/volt.js')}}"></script>
</head>

<body>
	<main>
		<!-- Section -->
		<section class="mt-5 bg-soft d-flex align-items-center">
			<div class="container">
				<div class="row justify-content-center">
					@yield('back')
					<div class="col d-flex align-items-center justify-content-center">
						<div class="bg-white shadow border-0 rounded border-light p-4 p-lg-5 w-100 fmxw-500">
							<div class="text-center text-md-center mb-4 mt-md-0">
								<h1 class="h3">@yield('header')</h1>
								@hasSection('desc') <p class="mb-4">@yield('desc')</p> @endif
							</div>
							<x-alert />
							<x-no-script />
							<x-caps-lock />
							@yield('form')
						</div>
					</div>
				</div>
			</div>
		</section>
	</main>
	<footer class="p-5 mb-4">
		<div class="container">
			<div class="col-12 d-flex align-items-center justify-content-center">
				<p class="mb-0 text-center">
					© <span class="current-year"></span> Data Mining
				</p>
			</div>
		</div>
	</footer>
	<script type="text/javascript" src="{{ asset('assets/js/capslock.js') }}"></script>
	@yield('js')
</body>

</html>
