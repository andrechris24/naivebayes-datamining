@extends('auth.layout')
@section('title', 'Reset Password')
@section('header', 'Reset Password')
@section('desc', 'Selamat datang kembali! Masukkan password baru untuk melanjutkan.')
@section('back')
<p class="text-center">
	<a href="{{ route('login') }}" class="text-gray-700">
		<i class="fas fa-arrow-left me-2"></i> Kembali ke Login
	</a>
</p>
@endsection
@section('form')
<form action="{{ route('password.reset') }}" method="POST" enctype="multipart/form-data">
	@csrf @method("PATCH")
	<input type="hidden" name="token" value="{{ $token }}">
	<div class="mb-4">
		<label for="email">Email</label>
		<div class="input-group">
			<input name="email" type="email" value="{{ $email }}"
				class="form-control @error('email') is-invalid @enderror " id="email" required readonly>
		</div>
		@error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
	</div>
	<!-- Form -->
	<div class="form-group mb-4">
		<label for="password">Password</label>
		<div class="input-group">
			<span class="input-group-text" id="basic-addon4">
				<svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20"
					xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd"
						d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
						clip-rule="evenodd"></path>
				</svg>
			</span>
			<input name="password" type="password" placeholder="Password"
				class="form-control @error('password') is-invalid @enderror " id="password" minlength="8" maxlength="20"
				oninput="checkpassword()" required>
		</div>
		@error('password')
		<div class="invalid-feedback">{{ $message }}</div>
		@enderror
	</div>
	<div class="form-group mb-4">
		<label for="password_confirmation">Konfirmasi Password</label>
		<div class="input-group">
			<span class="input-group-text" id="basic-addon5">
				<svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20"
					xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd"
						d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
						clip-rule="evenodd"></path>
				</svg>
			</span>
			<input name="password_confirmation" type="password" placeholder="Konfirmasi Password"
				class="form-control @error('password_confirmation') is-invalid @enderror " id="password_confirmation"
				oninput="checkpassword()" minlength="8" maxlength="20" required>
		</div>
		@error('password_confirmation')
		<div class="invalid-feedback">{{ $message }}</div>
		@enderror
	</div>
	<!-- End of Form -->
	<div class="d-grid">
		<button type="submit" class="btn btn-gray-800">Reset password</button>
	</div>
</form>
@endsection
@section('js')
<script type="text/javascript" src="{{ asset('assets/js/password.js') }}"></script>
@endsection