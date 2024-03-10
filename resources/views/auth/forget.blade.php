@extends('auth.layout')
@section('title', 'Lupa Password')
@section('header', 'Lupa Password')
@section('desc', 'Masukkan Email Anda untuk mendapatkan link reset password')
@section('form')
<form action="{{ route('password.send') }}" method="POST" enctype="multipart/form-data">
	@csrf
	<div class="form-floating mb-3">
		<input type="email" name="email" id="email" placeholder="Email" value="{{ old('email') }}"
			class="form-control @error('email') is-invalid @enderror " required>
		<label for="email">Email</label>
		@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
	</div>
	<button type="submit" class="btn btn-primary mb-3">
		<i class="bi bi-send-fill"></i> Kirim link
	</button>
	<p>Ingat akun Anda? <a href="{{ route('login') }}">Login</a></p>
</form>
@endsection