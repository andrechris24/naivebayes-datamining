@extends('auth.layout')
@section('title', 'Reset Password')
@section('header', 'Reset Password')
@section('desc', 'Selamat datang kembali! Masukkan password baru untuk melanjutkan.')
@section('form')
<form action="{{ route('password.reset') }}" method="POST" enctype="multipart/form-data">
	@csrf
	@method('PATCH')
	<input type="hidden" name="token" value="{{ $token }}">
	<div class="form-floating mb-3">
		<input type="email" name="email" id="email" value="{{ $email }}" placeholder="Email"
			class="form-control @error('email') is-invalid @enderror " readonly required>
		<label for="email">Email</label>
		@error('email')
		<div class="invalid-feedback">{{ $message }}</div>
		@enderror
	</div>
	<div class="form-floating mb-3">
		<input type="password" name="password" id="password-baru" minlength="8" maxlength="20"
			class="form-control @error('password') is-invalid @enderror " placeholder="Password baru"
			oninput="checkpassword()" required>
		<label for="password-baru">Password</label>
		@error('password')
		<div class="invalid-feedback">{{ $message }}</div>
		@enderror
	</div>
	<div class="form-floating mb-3">
		<input type="password" name="password_confirmation" id="konfirmasi" minlength="8"
			class="form-control @error('password_confirmation') is-invalid @enderror "
			placeholder="Konfirmasi Password" oninput="checkpassword()" maxlength="20" required>
		<label for="konfirmasi">Konfirmasi Password</label>
		@error('password_confirmation')
		<div class="invalid-feedback">{{ $message }}</div>
		@enderror
	</div>
	<button type="submit" class="btn btn-primary mb-3">
		<i class="bi bi-save2"></i> Simpan
	</button>
	<p>Ingat akun Anda? <a href="{{ route('login') }}">Login</a></p>
</form>
@endsection
@section('js')
<script type="text/javascript" src="{{ asset('assets/js/password.js') }}"></script>
@endsection