@extends('auth.layout')
@section('title', 'Registrasi')
@section('header', 'Buat Akun')
@section('desc', 'Selamat datang! Silahkan isi data Anda untuk membuat akun.')
@section('form')
<form action="{{ route('register.post') }}" method="POST" enctype="multipart/form-data" class="mt-4">
	@csrf
	<div class="form-group mb-4">
		<label for="nama">Nama</label>
		<div class="input-group">
			<span class="input-group-text" id="basic-addon0">
				<svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20"
					xmlns="http://www.w3.org/2000/svg">
					<path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
					<path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
				</svg>
			</span>
			<input type="text" name="name" class="form-control @error('name') is-invalid @enderror " id="nama"
				value="{{ old('name') }}" autofocus required>
		</div>
		@error('name')
		<div class="invalid-feedback">{{ $message }}</div>
		@enderror
	</div>
	<!-- Form -->
	<div class="form-group mb-4">
		<label for="email">Email</label>
		<div class="input-group">
			<span class="input-group-text" id="basic-addon1">
				<svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20"
					xmlns="http://www.w3.org/2000/svg">
					<path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
					<path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
				</svg>
			</span>
			<input type="email" name="email" value="{{ old('email') }}"
				class="form-control @error('email') is-invalid @enderror " placeholder="email@example.com" id="email"
				required>
		</div>
		@error('email')
		<div class="invalid-feedback">{{ $message }}</div>
		@enderror
	</div>
	<!-- End of Form -->
	<div class="form-group">
		<!-- Form -->
		<div class="form-group mb-4">
			<label for="password">Password</label>
			<div class="input-group">
				<span class="input-group-text" id="basic-addon2">
					<svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20"
						xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd"
							d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
							clip-rule="evenodd"></path>
					</svg>
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
				<span class="input-group-text" id="basic-addon2">
					<svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20"
						xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd"
							d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
							clip-rule="evenodd"></path>
					</svg>
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
		Sudah punya akun?
		<a href="{{ route('login') }}" class="fw-bold">Login disini</a>
	</span>
</div>
@endsection
@section('js')
<script type="text/javascript" src="{{ asset('assets/js/password.js') }}"></script>
@endsection