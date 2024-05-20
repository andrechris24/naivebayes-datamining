@extends('auth.layout')
@section('title', 'Lupa Password')
@section('header', 'Lupa Password')
@section('desc', 'Masukkan Email Anda untuk mendapatkan link reset password')
@section('back')
<p class="text-center">
	<a href="{{route('login')}}" class="d-flex align-items-center justify-content-center">
		<i class="fas fa-arrow-left me-2"></i> Kembali ke Login
	</a>
</p>
@endsection
@section('form')
<form action="{{ route('password.send') }}" method="POST" enctype="multipart/form-data">
	<!-- Form -->
	@csrf
	<div class="mb-4">
		<label for="email">Email</label>
		<div class="input-group">
			<span class="input-group-text">
				<i class="fas fa-envelope text-gray-600"></i>
			</span>
			<input type="email" class="form-control @error('email') is-invalid @enderror " name="email"
				value="{{ old('email') }}" id="email" placeholder="email@example.com" required autofocus>
		</div>
		@error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
	</div>
	<!-- End of Form -->
	<div class="d-grid">
		<button type="submit" class="btn btn-gray-800">
			<i class="fas fa-paper-plane"></i> Kirim link
		</button>
	</div>
</form>
@endsection