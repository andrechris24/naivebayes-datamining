@extends('layout')
@section('title', 'Edit Profil')
@section('content')
<p>Untuk melakukan perubahan, masukkan password Anda. Kosongkan password baru jika tidak ganti password.</p>
<x-caps-lock />
<form class="needs-validation" enctype="multipart/form-data" id="form-edit-account">
	@csrf
	<input type="hidden" name="id" value="{{ auth()->id() }}">
	<div class="row mb-3">
		<div class="col-md-3"><label for="nama-user">Nama</label></div>
		<div class="col-md-9">
			<div class="input-group has-validation">
				<span class="input-group-text"><i class="bi bi-person"></i></span>
				<input type="text" name="name" id="nama-user" value="{{ old('name') ?? auth()->user()->name }}"
					class="form-control" required>
				<div class="invalid-feedback" id="name-error">Masukkan Nama</div>
			</div>
		</div>
	</div>
	<div class="row mb-3">
		<div class="col-md-3"><label for="email-user">Email</label></div>
		<div class="col-md-9">
			<div class="input-group has-validation">
				<span class="input-group-text"><i class="bi bi-envelope"></i></span>
				<input type="email" name="email" value="{{ old('email') ?? auth()->user()->email }}"
					class="form-control" id="email-user" required>
				<div class="invalid-feedback" id="email-error">
					Masukkan Email (email@example.com)
				</div>
			</div>
		</div>
	</div>
	<div class="row mb-3">
		<div class="col-md-3"><label for="password-current">Password Anda</label></div>
		<div class="col-md-9">
			<div class="input-group has-validation">
				<span class="input-group-text"><i class="bi bi-lock"></i></span>
				<input type="password" name="current_password" placeholder="Password Akun Anda" class="form-control"
					minlength="8" maxlength="20" id="password-current" required>
				<div class="invalid-feedback" id="current-password-error">
					Masukkan Password Anda
				</div>
			</div>
		</div>
	</div>
	<div class="row mb-3">
		<div class="col-md-3"><label for="newpassword">Password baru</label></div>
		<div class="col-md-9">
			<div class="input-group has-validation">
				<span class="input-group-text"><i class="bi bi-lock"></i></span>
				<input type="password" name="password" id="newpassword" oninput="checkpassword()" class="form-control"
					minlength="8" maxlength="20" placeholder="Kosongkan jika tidak ganti password">
				<div class="invalid-feedback" id="newpassword-error">
					Password baru harus di antara 8-20 karakter
				</div>
			</div>
		</div>
	</div>
	<div class="row mb-3">
		<div class="col-md-3">
			<label for="conf-password">Konfirmasi Password baru</label>
		</div>
		<div class="col-md-9">
			<div class="input-group has-validation">
				<span class="input-group-text"><i class="bi bi-lock"></i></span>
				<input type="password" name="password_confirmation" id="conf-password" minlength="8"
					class="form-control" maxlength="20" placeholder="Password konfirmasi" oninput="checkpassword()">
				<div class="invalid-feedback" id="confirm-password-error">
					Password Konfirmasi salah
				</div>
			</div>
		</div>
	</div>
	<hr>
	<div class="btn-group">
		<a href="{{ route('home') }}" class="btn btn-warning">
			<i class="bi bi-arrow-left-circle"></i> Kembali
		</a>
		<button type="button" class="btn btn-danger" id="DelAccountBtn">
			<i class="bi bi-trash3-fill"></i> Hapus Akun
		</button>
		<button type="submit" class="btn btn-primary data-submit">
			<i class="bi bi-save"></i> Simpan perubahan
		</button>
	</div>
	<div class="spinner-grow text-primary d-none" role="status">
		<span class="visually-hidden">Menyimpan...</span>
	</div>
</form>
@endsection
@section('js')
<script type="text/javascript" src="{{ asset('assets/js/capslock.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/password.js') }}"></script>
<script type="text/javascript">
	let errmsg;
	function submitform(e) {
		e.preventDefault();
		$.ajax({
			data: $("#form-edit-account").serialize(),
			url: "{{ route('profil.update') }}",
			type: "PATCH",
			beforeSend: function () {
				$("#form-edit-account :input").removeClass("is-invalid");
				$(".form-edit-account :button").prop("disabled", true);
				formloading("#form-edit-account :input",true);
			},
			complete: function () {
				$(".form-edit-account").prop("disabled", false);
				formloading("#form-edit-account :input",false);
			},
			success: function () {
				$("input[type=password]").val("");
				resetvalidation();
				swal.fire({
					icon: "success",
					titleText: "Tersimpan"
				});
			},
			error: function (xhr, st) {
				if (xhr.status === 422) {
					resetvalidation();
					if (typeof xhr.responseJSON.errors.name !== "undefined") {
						$("#nama-user").addClass("is-invalid");
						$("#name-error").text(xhr.responseJSON.errors.name);
					}
					if (typeof xhr.responseJSON.errors.email !== "undefined") {
						$("#email-user").addClass("is-invalid");
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
					errmsg = `Kesalahan HTTP ${xhr.status}. ${xhr.statusText}`;
				}
				swal.fire({
					titleText: "Gagal simpan",
					text: errmsg,
					icon: "error"
				});
			}
		});
	};
	$(document).on("click", "#DelAccountBtn", function () {
		confirm.fire({
			titleText: "Hapus Akun?",
			text: "Jika Anda sudah yakin ingin menghapus akun, " +
				"masukkan password Anda untuk melanjutkan.",
			input: "password",
			inputLabel: "Password",
			inputPlaceholder: "Password Anda",
			inputAttributes: {
				maxlength: 20,
				autocapitalize: "off",
				autocorrect: "off"
			},
			inputValidator: (value) => {
				if (!value) return "Masukkan Password Anda";
				else if (value.length < 8 || value.length > 20)
					return "Panjang Password harus 8-20 karakter";
			},
			preConfirm: async (password) => {
				try {
					await $.ajax({
						url: "{{ route('profil.delete') }}",
						type: "DELETE",
						data: {
							del_password: password
						},
						headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
						success: function () {
							return "{{ route('login') }}";
						},
						error: function (xhr, st) {
							if (xhr.status === 422)
								errmsg = xhr.responseJSON.message;
							else if (xhr.status === 429)
								errmsg = "Terlalu banyak upaya. Cobalah beberapa saat lagi.";
							else {
								console.warn(xhr.responseJSON.message ?? st);
								errmsg = `Gagal hapus: Kesalahan HTTP ${xhr.status}. ${xhr.statusText}`;
							}
							return Swal.showValidationMessage(errmsg);
						}
					});
				} catch (error) {
					console.error(error.responseJSON);
				}
			}
		}).then((result) => {
			if (result.isConfirmed) {
				swal.fire({
					titleText: "Akun sudah dihapus",
					icon: "success"
				});
				location.href = "{{ route('login') }}";
			}
		});
	});
</script>
@endsection