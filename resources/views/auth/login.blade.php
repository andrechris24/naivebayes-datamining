@extends('auth.layout')
@section('title', 'Login')
@section('header', 'Login')
@section('desc', 'Silahkan login dengan data yang sudah Anda daftarkan.')
@section('form')
<form action="{{ route('login.post') }}" method="POST" enctype="multipart/form-data">
	@csrf
	<div class="form-floating mb-3">
		<input type="email" name="email" id="email" value="{{ old('email') }}"
			class="form-control @error('email') is-invalid @enderror " placeholder="Email" required>
		<label for="email">Email</label>
		@error('email')
		<div class="invalid-feedback">{{ $message }}</div>
		@enderror
	</div>
	<div class="form-floating mb-3">
		<input type="password" name="password" id="katasandi" placeholder="Password" minlength="8"
			class="form-control @error('password') is-invalid @enderror " maxlength="20" required>
		<label for="katasandi">Password</label>
		@error('password')
		<div class="invalid-feedback">{{ $message }}</div>
		@enderror
	</div>
	<div class="form-check mb-3">
		<input class="form-check-input" type="checkbox" value="1" id="remember" name="remember">
		<label class="form-check-label" for="remember">Simpan Informasi Login</label>
	</div>
	<button type="submit" class="btn btn-primary mb-3">
		<i class="bi bi-door-open-fill"></i> Login
	</button>
	<p>
		Belum punya akun? <a href="{{ route('register') }}">Daftar</a><br>
		<a href="{{ route('password.forget') }}">Lupa Password</a>
	</p>
</form>
@endsection