@extends('auth.layout')
@section('title', 'Lupa Password')
@section('header', 'Lupa Password')
@section('desc', 'Masukkan Email Anda untuk mendapatkan link reset password')
@section('back')
<p class="text-center">
	<a href="{{route('login')}}" class="d-flex align-items-center justify-content-center">
		<svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
			<path fill-rule="evenodd"
				d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
				clip-rule="evenodd"></path>
		</svg>
		Kembali ke Login
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
			<input type="email" class="form-control @error('email') is-invalid @enderror " name="email"
				value="{{ old('email') }}" id="email" placeholder="email@example.com" required autofocus>
		</div>
		@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
	</div>
	<!-- End of Form -->
	<div class="d-grid">
		<button type="submit" class="btn btn-gray-800">
			<i class="fas fa-paper-plane"></i> Kirim link
		</button>
	</div>
</form>
@endsection