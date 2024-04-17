@section('title','Buat Akun')
<div wire:ignore.self class="row justify-content-center form-bg-image">
	<div class="col-12 d-flex align-items-center justify-content-center">
		<div class="bg-white shadow border-0 rounded border-light p-4 p-lg-5 w-100 fmxw-500">
			<div class="text-center text-md-center mb-4 mt-md-0">
				<h1 class="mb-0 h3">Buat Akun</h1>
			</div>
			<x-alert />
			<x-no-script />
			<x-caps-lock />
			<form wire:submit.prevent="register" action="#" method="POST">
				<!-- Form -->
				<div class="form-group mt-4 mb-4">
					<label for="name">Nama</label>
					<div class="input-group">
						<span class="input-group-text" id="basic-addon3">
							<svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20"
								xmlns="http://www.w3.org/2000/svg">
								<path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
								<path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
							</svg>
						</span>
						<input wire:model="name" id="name" type="text" class="form-control @error('name') is-invalid @enderror " placeholder="Nama Anda"
							autofocus required>
					</div>
					@error('name')
					<div class="invalid-feedback">{{ $message }}</div>
					@enderror
				</div>
				<!-- End of Form -->
				<!-- Form -->
				<div class="form-group mb-4">
					<label for="email">Email</label>
					<div class="input-group">
						<span class="input-group-text" id="basic-addon3">
							<svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20"
								xmlns="http://www.w3.org/2000/svg">
								<path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
								<path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
							</svg>
						</span>
						<input wire:model="email" id="email" type="email" class="form-control @error('email') is-invalid @enderror "
							placeholder="example@company.com" required>
					</div>
					@error('email')
					<div class="invalid-feedback">{{ $message }}</div>
					@enderror
				</div>
				<!-- End of Form -->
				<div class="form-group">
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
							<input wire:model.lazy="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror "
								id="password" minlength="8" maxlength="20" required>
						</div>
						@error('password')
						<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
					<!-- End of Form -->
					<!-- Form -->
					<div class="form-group mb-4">
						<label for="confirm_password">Konfirmasi Password</label>
						<div class="input-group">
							<span class="input-group-text" id="basic-addon5">
								<svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20"
									xmlns="http://www.w3.org/2000/svg">
									<path fill-rule="evenodd"
										d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
										clip-rule="evenodd"></path>
								</svg>
							</span>
							<input wire:model.lazy="password_confirmation" type="password" placeholder="Konfirmasi Password"
								class="form-control @error('password_confirmation') is-invalid @enderror " id="confirm_password" minlength="8" maxlength="20" required>
						</div>
						@error('password_confirmation')
						<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
					<!-- End of Form -->
				</div>
				@if(!empty($error))
				<div class="alert alert-danger" role="alert">{{$error}}</div>
				@endif
				<div class="d-grid">
					<button type="submit" class="btn btn-gray-800">
						<i class="fas fa-arrow-right-to-bracket"></i> Buat Akun
					</button>
				</div>
			</form>
			<div class="d-flex justify-content-center align-items-center mt-4">
				<span class="fw-normal">Sudah punya akun?
					<a href="{{ route('login') }}" class="fw-bold">Login</a>
				</span>
			</div>
		</div>
	</div>
</div>