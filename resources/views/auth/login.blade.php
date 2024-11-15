@extends('auth.layout')
@section('title', 'Login')
@section('header', 'Login')
@section('desc', 'Silahkan login dengan data yang sudah Anda daftarkan.')
@section('form')
<form action="{{ route('login.submit') }}" class="mt-4" method="POST" enctype="multipart/form-data">
	<div class="form-group mb-4">@csrf
		<label for="email">Email</label>
		<div class="input-group">
			<span class="input-group-text">
				<i class="fas fa-envelope text-gray-600"></i>
			</span>
			<input type="email" class="form-control @error('email') is-invalid @enderror "
				placeholder="email@example.com" id="email" name="email" value="{{ old('email') }}" autofocus required>
		</div>
		@error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
	</div>
	<div class="form-group">
		<div class="form-group mb-4">
			<label for="password">Password</label>
			<div class="input-group">
				<span class="input-group-text">
					<i class="fas fa-lock text-gray-600"></i>
				</span>
				<input type="password" placeholder="Password" name="password" id="password" minlength="8"
					class="form-control @error('password') is-invalid @enderror " maxlength="20" required>
			</div>
			@error('password')
			<div class="invalid-feedback">{{ $message }}</div>
			@enderror
		</div>
		<div class="d-flex justify-content-between align-items-top mb-4">
			<div class="form-check">
				<input class="form-check-input" type="checkbox" value="1" id="remember" name="remember">
				<label class="form-check-label mb-0" for="remember">
					Simpan informasi login
				</label>
			</div>
			<div>
				<a href="{{ route('password.forget') }}" class="small text-right">
					Lupa password?
				</a>
			</div>
		</div>
	</div>
	<div class="d-grid">
		<button type="submit" class="btn btn-gray-800">
			<i class="fas fa-right-to-bracket"></i> Login
		</button>
	</div>
</form>
<div class="d-flex justify-content-center align-items-center mt-4">
	<span class="fw-normal">
		Belum punya akun? <a href="{{route('register')}}" class="fw-bold">Buat Akun</a>
	</span>
</div>
@endsection