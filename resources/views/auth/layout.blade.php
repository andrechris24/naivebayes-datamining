<!DOCTYPE HTML>
<html data-bs-theme="auto">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		@yield('title') | Aplikasi Klasifikasi Kelayakan Calon Penerima Bansos
	</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<link rel="stylesheet"
		href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/theme.css') }}">
	<script type="text/javascript" src="{{ asset('assets/js/theme.js') }}"></script>
</head>

<body>
	<x-theme />
	<div class="container my-5">
		<div class="card">
			<div class="card-header text-center">
				<b>Selamat datang di Aplikasi Klasifikasi Kelayakan Calon Penerima Bantuan Sosial</b>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-lg-7">
						<img src="{{ asset('assets/images/bg-auth.jpg') }}" class="img-fluid rounded-start">
					</div>
					<div class="col-lg-5">
						<h3 class="card-title">@yield('header')</h3>
						<hr>
						<p>@yield('desc')</p>
						<x-alert />
						<x-no-script />
						<x-caps-lock />
						@yield('form')
					</div>
				</div>
			</div>
			<div class="card-footer text-center">
				&copy; Copyright {{ date('Y') }} Data Mining
			</div>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
	</script>
	<script src="https://code.jquery.com/jquery-3.7.1.min.js"
		integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
	<script type="text/javascript" src="{{ asset('assets/js/capslock.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/tooltip.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/validate.js') }}"></script>
	@yield('js')
</body>

</html>