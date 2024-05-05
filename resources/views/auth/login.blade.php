@extends('auth.layout')
@section('title', 'Login')
@section('header', 'Login')
@section('desc', 'Silahkan login dengan data yang sudah Anda daftarkan.')
@section('form')
<form action="{{ route('login.submit') }}" class="mt-4" method="POST" enctype="multipart/form-data">
	@csrf
	<!-- Form -->
	<div class="form-group mb-4">
		<label for="email">Email</label>
		<div class="input-group">
			<span class="input-group-text" id="basic-addon1">
				<svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20"
					xmlns="http://www.w3.org/2000/svg">
					<path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z">
					</path>
					<path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
				</svg>
			</span>
			<input type="email" class="form-control @error('email') is-invalid @enderror "
				placeholder="email@example.com" id="email" name="email" value="{{ old('email') }}" autofocus required>
		</div>
		@error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
				<input type="password" placeholder="Password" name="password" id="password" minlength="8"
					class="form-control @error('password') is-invalid @enderror " maxlength="20" required>
			</div>
			@error('password')
			<div class="invalid-feedback">{{ $message }}</div>
			@enderror
		</div>
		<!-- End of Form -->
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