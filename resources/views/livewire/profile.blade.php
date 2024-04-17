@section('title','Edit Profil')
<div class="card card-body border-0 shadow mb-4">
	<x-caps-lock />
	<form enctype="multipart/form-data" id="form-edit-account" wire:submit="update">
		<div class="form-group position-relative mb-3">
			<div class="row">
				<div class="col-lg-3"><label for="name">Nama</label></div>
				<div class="col-lg-9">
					<input class="form-control @error('name') is-invalid @enderror " id="name" type="text" placeholder="Masukkan Nama Anda" wire:model="name" required>
					@error('name')
					<div class="invalid-feedback">{{$message}}</div>
					@enderror
				</div>
			</div>
		</div>
		<div class="form-group position-relative mb-3">
			<div class="row">
				<div class="col-lg-3"><label for="email">Email</label></div>
				<div class="col-lg-9">
					<input class="form-control @error('email') is-invalid @enderror " id="email" type="email" placeholder="email@example.com" wire:model="email" required>
					@error('email')
					<div class="invalid-feedback">{{$message}}</div>
					@enderror
				</div>
			</div>
		</div>
		<div class="form-group position-relative mb-3">
			<div class="row">
				<div class="col-lg-3">
					<label for="password-current">Password Anda</label>
				</div>
				<div class="col-lg-9">
					<input class="form-control @error('current_password') is-invalid @enderror " id="password-current" type="password" minlength="8" maxlength="20" placeholder="Password Anda" wire:model="current_password" required>
					@error('current_password')
					<div class="invalid-feedback">{{$message}}</div>
					@enderror
				</div>
			</div>
		</div>
		<div class="form-group position-relative mb-3">
			<div class="row">
				<div class="col-lg-3">
					<label for="newpassword">Password Baru</label>
				</div>
				<div class="col-lg-9">
					<input class="form-control @error('password') is-invalid @enderror " id="newpassword" type="password" minlength="8" maxlength="20" placeholder="Kosongkan jika tidak ganti password" wire:model.lazy="password">
					@error('password')
					<div class="invalid-feedback">{{$message}}</div>
					@enderror
				</div>
			</div>
		</div>
		<div class="form-group position-relative mb-3">
			<div class="row">
				<div class="col-lg-3">
					<label for="conf-password">Konfirmasi Password Baru</label>
				</div>
				<div class="col-lg-9">
					<input class="form-control @error('password_confirmation') is-invalid @enderror " id="conf-password" type="password" minlength="8" maxlength="20" placeholder="Konfirmasi password baru" wire:model.lazy="password_confirmation">
					@error('password_confirmation')
					<div class="invalid-feedback">{{$message}}</div>
					@enderror
				</div>
			</div>
		</div>
		<div class="btn-group mt-3">
			<a href="{{ route('home') }}" class="btn btn-warning">
				<i class="fas fa-arrow-left"></i> Kembali
			</a>
			<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalDelAkun">
				<i class="fas fa-trash"></i> Hapus Akun
			</button>
			<button type="submit" class="btn btn-primary">
				<i class="fas fa-floppy-disk"></i> Simpan Perubahan
			</button>
		</div>
		<span wire:loading wire:target="update">Menyimpan...</span>
	</form>
	<div wire:ignore.self class="modal fade" tabindex="-1" id="modalDelAkun" aria-labelledby="modalDelAkunLabel"
		data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
			<div class="modal-content">
				<div class="modal-header bg-danger">
					<h5 id="modalDelAkunLabel" class="modal-title text-white">Hapus Akun</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<x-caps-lock />
					<p>Apakah Anda yakin ingin menghapus akun?
						Jika sudah yakin, masukkan password Anda untuk melanjutkan.</p>
					<form id="DelAkunForm" wire:submit="delete">
						<input type="password" class="form-control @error('confirm_pass') is-invalid @enderror " wire:model="confirm_pass" placeholder="Password Anda" required>
						@error('confirm_pass')
						<div class="invalid-feedback">{{$message}}</div>
						@enderror
					</form>
				</div>
				<div class="modal-footer">
					<span wire:loading wire:target="delete">Menghapus...</span>
					<button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">
						<i class="fas fa-x"></i> Batal
					</button>
					<button type="submit" class="btn btn-danger" form="DelAkunForm">
						<i class="fas fa-check"></i> Hapus
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
@push('js')
<script type="text/javascript" src="{{ asset('assets/js/capslock.js') }}"></script>
<script type="text/javascript">
	Livewire.on('toast', (r) => {
		notif.open({ type: r.tipe, message: r.message });
	});
</script>
@endpush