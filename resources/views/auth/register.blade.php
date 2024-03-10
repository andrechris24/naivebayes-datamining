@extends('auth.layout')
@section('title', 'Registrasi')
@section('header', 'Registrasi')
@section('desc',
'Selamat datang! Silahkan isi data Anda untuk membuat akun.')
@section('form')
<form action="{{ route('register.post') }}" method="POST" enctype="multipart/form-data">
	@csrf
	<div class="form-floating mb-3">
		<input type="text" name="name" id="nama" value="{{ old('name') }}" placeholder="Nama"
			class="form-control @error('name') is-invalid @enderror " required>
		<label for="nama">Nama</label>
		@error('name')
		<div class="invalid-feedback">{{ $message }}</div>
		@enderror
	</div>
	<div class="form-floating mb-3">
		<input type="email" name="email" id="email" value="{{ old('email') }}"
			class="form-control @error('email') is-invalid @enderror " placeholder="Email" required>
		<label for="email">Email</label>
		@error('email')
		<div class="invalid-feedback">{{ $message }}</div>
		@enderror
	</div>
	<div class="form-floating mb-3">
		<input type="password" name="password" id="katasandi" minlength="8" maxlength="20"
			class="form-control @error('password') is-invalid @enderror " placeholder="Password"
			oninput="checkpassword()" data-bs-toggle="tooltip" title="8-20 karakter" required>
		<label for="katasandi">Password</label>
		@error('password')
		<div class="invalid-feedback">{{ $message }}</div>
		@enderror
	</div>
	<div class="form-floating mb-3">
		<input type="password" name="password_confirmation" id="konfirmasi" minlength="8"
			class="form-control @error('password_confirmation') is-invalid @enderror "
			placeholder="Konfirmasi password" oninput="checkpassword()" maxlength="20" required>
		<label for="konfirmasi">Konfirmasi Password</label>
		@error('password_confirmation')
		<div class="invalid-feedback">{{ $message }}</div>
		@enderror
	</div>
	<button type="submit" class="btn btn-primary mb-3">
		<i class="bi bi-box-arrow-in-right"></i> Buat Akun
	</button>
	<p>Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>
</form>
@endsection
@section('js')
<script type="text/javascript" src="{{ asset('assets/js/password.js') }}"></script>
@endsection