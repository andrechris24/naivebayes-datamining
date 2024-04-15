@section('title','Lupa Password')
<div class="row justify-content-center form-bg-image">
	<p class="text-center">
		<a href="{{ route('login') }}" class="d-flex align-items-center justify-content-center">
			<svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd"
					d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
					clip-rule="evenodd"></path>
			</svg> Kembali ke Login
		</a>
	</p>
	<div class="col-12 d-flex align-items-center justify-content-center">
		<div class="signin-inner my-3 my-lg-0 bg-white shadow border-0 rounded p-4 p-lg-5 w-100 fmxw-500">
			<h1 class="h3">Lupa Password</h1>
			<p class="mb-4">Masukkan email yang lupa password</p>
			<x-alert />
			<x-no-script />
			<form wire:submit.prevent="recoverPassword" action="#" method="POST">
				<!-- Form -->
				<div class="mb-4">
					<label for="email">Email</label>
					<div class="input-group">
						<input wire:model='email' type="email" class="form-control" id="email"
							placeholder="john@company.com" required autofocus>
					</div>
					@error('email')
					<div class="invalid-feedback">{{ $message }}</div>
					@enderror
				</div>
				<!-- End of Form -->
				@if($mailSentAlert)
				<div class="alert alert-success" role="alert">
					{{__('passwords.sent')}}
				</div>
				@endif
				@if(!empty($error))
				<div class="alert alert-danger" role="alert">{{$error}}</div>
				@endif
				<div class="d-grid">
					<button type="submit" class="btn btn-gray-800">
						<i class="fas fa-paper-plane"></i> Kirim link
					</button>
				</div>
			</form>
		</div>
	</div>
</div>