@extends('layout')
@section('title', 'Edit Profil')
@section('content')
<p>Untuk melakukan perubahan, masukkan password Anda.
	Kosongkan password baru jika tidak ganti password.</p>
<div class="modal fade" tabindex="-1" id="modalDelAkun" aria-labelledby="modalDelAkunLabel"
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
				<form id="DelAkunForm">@csrf
					<div class="position-relative">
						<input type="password" class="form-control" id="password-conf" minlength="8" maxlength="20"
							name="confirm_pass" placeholder="Password Anda" required>
						<div class="invalid-feedback" id="del-error"></div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
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
<div class="card card-body border-0 shadow mb-3">
	<x-caps-lock />
	<form enctype="multipart/form-data" id="form-edit-account">
		<input type="hidden" name="id" value="{{ auth()->id() }}">@csrf
		<div class="form-group position-relative mb-3">
			<div class="row">
				<div class="col-lg-3"><label for="name">Nama</label></div>
				<div class="col-lg-9">
					<input class="form-control" id="name" type="text" name="name" placeholder="Masukkan Nama Anda"
						value="{{ auth()->user()->name }}" required>
					<div class="invalid-feedback" id="name-error"></div>
				</div>
			</div>
		</div>
		<div class="form-group position-relative mb-3">
			<div class="row">
				<div class="col-lg-3"><label for="email">Email</label></div>
				<div class="col-lg-9">
					<input class="form-control" id="email" type="email" name="email" placeholder="email@example.com"
						value="{{ auth()->user()->email }}" required>
					<div class="invalid-feedback" id="email-error"></div>
				</div>
			</div>
		</div>
		<div class="form-group position-relative mb-3">
			<div class="row">
				<div class="col-lg-3">
					<label for="password-current">Password Anda</label>
				</div>
				<div class="col-lg-9">
					<input class="form-control" id="password-current" type="password" minlength="8" maxlength="20"
						placeholder="Password Anda" name="current_password" required>
					<div class="invalid-feedback" id="current-password-error"></div>
				</div>
			</div>
		</div>
		<div class="form-group position-relative mb-3">
			<div class="row">
				<div class="col-lg-3">
					<label for="newpassword">Password Baru</label>
				</div>
				<div class="col-lg-9">
					<input class="form-control" id="newpassword" type="password" oninput="checkpassword()" minlength="8"
						maxlength="20" placeholder="Kosongkan jika tidak ganti password" name="password">
					<div class="invalid-feedback" id="newpassword-error"></div>
				</div>
			</div>
		</div>
		<div class="form-group position-relative mb-3">
			<div class="row">
				<div class="col-lg-3">
					<label for="conf-password">Konfirmasi Password Baru</label>
				</div>
				<div class="col-lg-9">
					<input class="form-control" id="conf-password" type="password" minlength="8" maxlength="20"
						placeholder="Konfirmasi password baru" name="password_confirmation" oninput="checkpassword()">
					<div class="invalid-feedback" id="confirm-password-error"></div>
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
	</form>
</div>
@endsection
@section('js')
<script type="text/javascript" src="{{ asset('assets/js/capslock.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/password.js') }}"></script>
<script type="text/javascript">
	let errmsg;
	$("#form-edit-account").submit(function(e) {
		e.preventDefault();
		$.ajax({
			data: $("#form-edit-account").serialize(),
			url: "{{ route('profil.update') }}",
			type: "POST",
			beforeSend: function () {
				resetvalidation();
				$.LoadingOverlay('show');
			}, complete: function () {
				$.LoadingOverlay('hide');
			}, success: function (data) {
				$("input[type=password]").val("");
				$("#nama-pengguna").text(data.nama);
				iziToast.success({title: "Tersimpan",displayMode: 2});
			}, error: function (xhr, st) {
				if (xhr.status === 422) {
					if (typeof xhr.responseJSON.errors.name !== "undefined") {
						$("#name").addClass("is-invalid");
						$("#name-error").text(xhr.responseJSON.errors.name);
					}
					if (typeof xhr.responseJSON.errors.email !== "undefined") {
						$("#email").addClass("is-invalid");
						$("#email-error").text(xhr.responseJSON.errors.email);
					}
					if (typeof xhr.responseJSON.errors.current_password !== "undefined") {
						$("#password-current").addClass("is-invalid");
						$("#current-password-error").text(
							xhr.responseJSON.errors.current_password);
					}
					if (typeof xhr.responseJSON.errors.password !== "undefined") {
						$("#newpassword").addClass("is-invalid");
						$("#newpassword-error").text(xhr.responseJSON.errors.password);
					}
					if (typeof xhr.responseJSON.errors.password_confirmation !==
						"undefined") {
						$("#conf-password").addClass("is-invalid");
						$("#confirm-password-error").text(
							xhr.responseJSON.errors.password_confirmation);
					}
					errmsg = xhr.responseJSON.message;
				} else if (xhr.status === 429) {
					errmsg = "Terlalu banyak upaya. " +
						"Tunggu beberapa saat sebelum menyimpan perubahan.";
				} else {
					console.warn(xhr.responseJSON.message ?? st);
					errmsg = `Kesalahan HTTP ${xhr.status} ${xhr.statusText}`;
				}
				iziToast.error({title: "Gagal simpan",message: errmsg,displayMode: 2});
			}
		});
	});
	$("#DelAkunForm").submit(function (e) {
		e.preventDefault();
		$.ajax({
			url: "{{ route('profil.delete') }}",
			type: "DELETE",
			data: $("#DelAkunForm").serialize(),
			beforeSend: function(){
				resetvalidation();
				$.LoadingOverlay('show');
			}, success: function () {
				setTimeout(function(){
					$.LoadingOverlay("hide");
				}, 5000);
				location.replace("{{route('login')}}");
			}, error: function (xhr, st) {
				iziToast.hide({}, document.querySelector('.izitoast_loader'));
				if (xhr.status === 422) errmsg = xhr.responseJSON.message;
				else if (xhr.status === 429)
					errmsg = "Terlalu banyak upaya. Cobalah beberapa saat lagi.";
				else {
					console.warn(xhr.responseJSON.message ?? st);
					errmsg = `Kesalahan HTTP ${xhr.status} ${xhr.statusText}`;
				}
				$("#password-conf").addClass('is-invalid');
				$("#del-error").text(xhr.responseJSON.message);
				$("#DelAkunForm").modal("handleUpdate");
				iziToast.error({title: "Gagal hapus",message: errmsg,displayMode: 2});
			}
		});
	});
</script>
@endsection