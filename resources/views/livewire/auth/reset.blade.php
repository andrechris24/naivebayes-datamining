@section('title','Reset Password')
<div class="row justify-content-center form-bg-image">
	<p class="text-center">
		<a href="{{ route('login') }}" class="text-gray-700">
			<i class="fas fa-angle-left me-2"></i> Kembali ke Login
		</a>
	</p>
	<div class="col-12 d-flex align-items-center justify-content-center">
		<div class="bg-white shadow border-0 rounded p-4 p-lg-5 w-100 fmxw-500">
			<h1 class="h3 mb-4">Reset password</h1>
			<x-alert />
			<x-no-script />
			<x-caps-lock wire:ignore />
			<form wire:submit.prevent="resetPassword" action="#" method="POST">
				<input wire:model="token" type="hidden">
				<!-- Form -->
				<div class="mb-4">
					<label for="email">Email</label>
					<div class="input-group">
						<input wire:model="email" type="email" class="form-control @error('email') is-invalid @enderror "
							placeholder="email@example.com" id="email" readonly>
					</div>
					@error('email')
					<div class="invalid-feedback">{{ $message }}</div>
					@enderror
				</div>
				<!-- End of Form -->
				<!-- Form -->
				<div class="form-group mb-4">
					<label for="password">Password Baru</label>
					<div class="input-group">
						<span class="input-group-text" id="basic-addon4">
							<svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20"
								xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd"
									d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
									clip-rule="evenodd"></path>
							</svg>
						</span>
						<input wire:model="password" type="password" placeholder="Password" minlength="8" maxlength="20"
							class="form-control @error('password') is-invalid @enderror " id="password" required>
					</div>
					@error('password')
					<div class="invalid-feedback">{{ $message }}</div>
					@enderror
				</div>
				<!-- End of Form -->
				<!-- Form -->
				<div class="form-group mb-4">
					<label for="passwordConfirmation">Konfirmasi Password</label>
					<div class="input-group">
						<span class="input-group-text" id="basic-addon5">
							<svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20"
								xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd"
									d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
									clip-rule="evenodd"></path>
							</svg>
						</span>
						<input wire:model="password_confirmation" type="password" placeholder="Konfirmasi Password"
							class="form-control @error('password_confirmation') is-invalid @enderror "
							id="passwordConfirmation" minlength="8" maxlength="20" required>
					</div>
					@error('password_confirmation')
					<div class="invalid-feedback">{{ $message }}</div>
					@enderror
				</div>
				<!-- End of Form -->
				<div class="d-grid">
					<button type="submit" class="btn btn-gray-800">
						Reset Password
					</button>
				</div>
			</form>
		</div>
	</div>
</div>
@push('js')
<script type="text/javascript">
	Livewire.on('error',(e)=>{
		Notiflix.Notify.failure(e.message,{timeout:5000});
	});
</script>
@endpush