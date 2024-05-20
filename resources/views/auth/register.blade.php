@extends('auth.layout')
@section('title', 'Registrasi')
@section('header', 'Buat Akun')
@section('desc', 'Selamat datang! Silahkan isi data Anda untuk membuat akun.')
@section('form')
<form action="{{ route('register.submit') }}" method="POST" enctype="multipart/form-data" class="mt-4">
	@csrf
	<div class="form-group mb-4">
		<label for="nama">Nama</label>
		<div class="input-group">
			<span class="input-group-text">
				<i class="fas fa-user text-gray-600"></i>
			</span>
			<input type="text" name="name" class="form-control @error('name') is-invalid @enderror " id="nama"
				value="{{ old('name') }}" placeholder="Nama Anda" autofocus required>
		</div>
		@error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
	</div>
	<!-- Form -->
	<div class="form-group mb-4">
		<label for="email">Email</label>
		<div class="input-group">
			<span class="input-group-text">
				<i class="fas fa-envelope text-gray-600"></i>
			</span>
			<input type="email" name="email" value="{{ old('email') }}"
				class="form-control @error('email') is-invalid @enderror " placeholder="email@example.com" id="email"
				required>
		</div>
		@error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
	</div>
	<!-- End of Form -->
	<div class="form-group">
		<!-- Form -->
		<div class="form-group mb-4">
			<label for="password">Password</label>
			<div class="input-group">
				<span class="input-group-text">
					<i class="fas fa-lock text-gray-600"></i>
				</span>
				<input type="password" name="password" placeholder="Password"
					class="form-control @error('password') is-invalid @enderror " id="password" minlength="8"
					maxlength="20" oninput="checkpassword()" data-bs-toggle="tooltip" title="8-20 karakter" required>
			</div>
			@error('password')
			<div class="invalid-feedback">{{ $message }}</div>
			@enderror
		</div>
		<!-- End of Form -->
		<!-- Form -->
		<div class="form-group mb-4">
			<label for="confirm_password">Konfirmasi Password</label>
			<div class="input-group">
				<span class="input-group-text">
					<i class="fas fa-lock text-gray-600"></i>
				</span>
				<input type="password" name="password_confirmation" placeholder="Konfirmasi Password"
					class="form-control @error('password_confirmation') is-invalid @enderror " minlength="8"
					maxlength="20" oninput="checkpassword()" id="confirm_password" required>
			</div>
			@error('password_confirmation')
			<div class="invalid-feedback">{{ $message }}</div>
			@enderror
		</div>
		<!-- End of Form -->
	</div>
	<div class="d-grid">
		<button type="submit" class="btn btn-gray-800">
			<i class="fas fa-arrow-right-to-bracket"></i> Buat Akun
		</button>
	</div>
</form>
<div class="d-flex justify-content-center align-items-center mt-4">
	<span class="fw-normal">
		Sudah punya akun? <a href="{{ route('login') }}" class="fw-bold">Login</a>
	</span>
</div>
@endsection
@section('js')
<script type="text/javascript" src="{{ asset('assets/js/password.js') }}"></script>
@endsection