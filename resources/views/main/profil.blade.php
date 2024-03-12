@extends('layout')
@section('title', 'Edit Profil')
@section('content')
<x-caps-lock />
<form action="{{ route('profil.update') }}" class="needs-validation" method="POST" enctype="multipart/form-data"
	id="form-edit-account">
	@csrf
	<input type="hidden" name="id" value="{{ auth()->id() }}">
	<div class="row mb-3">
		<div class="col-md-3"><label for="nama">Nama</label></div>
		<div class="col-md-9">
			<input type="text" name="name" id="nama" value="{{ old('name') ?? auth()->user()->name }}"
				class="form-control @error('name') is-invalid @enderror " required>
			@error('name')
			<div class="invalid-feedback" id="name-error">{{ $message }}</div>
			@enderror
		</div>
	</div>
	<div class="row mb-3">
		<div class="col-md-3"><label for="email">Email</label></div>
		<div class="col-md-9">
			<input type="email" name="email" value="{{ old('email') ?? auth()->user()->email }}"
				class="form-control @error('email') is-invalid @enderror " id="email" required>
			@error('email')
			<div class="invalid-feedback">{{ $message }}</div>
			@enderror
		</div>
	</div>
	<div class="row mb-3">
		<div class="col-md-3"><label for="password-lama">Password Anda</label></div>
		<div class="col-md-9">
			<input type="password" name="current_password" placeholder="Password Akun Anda"
				class="form-control @error('current_password') is-invalid @enderror " minlength="8" maxlength="20"
				id="password-lama" required>
			@error('current_password')
			<div class="invalid-feedback">{{ $message }}</div>
			@enderror
		</div>
	</div>
	<div class="row mb-3">
		<div class="col-md-3"><label for="password-baru">Password baru</label></div>
		<div class="col-md-9">
			<input type="password" name="password" id="password-baru" oninput="checkpassword()"
				class="form-control @error('password') is-invalid @enderror "
				placeholder="Kosongkan jika tidak ganti password" minlength="8" maxlength="20">
			@error('password')
			<div class="invalid-feedback">{{ $message }}</div>
			@enderror
		</div>
	</div>
	<div class="row mb-3">
		<div class="col-md-3">
			<label for="konfirmasi">Konfirmasi Password baru</label>
		</div>
		<div class="col-md-9">
			<input type="password" name="password_confirmation" id="konfirmasi" minlength="8"
				class="form-control @error('password_confirmation') is-invalid @enderror " maxlength="20"
				placeholder="Password konfirmasi" oninput="checkpassword()">
			@error('password_confirmation')
			<div class="invalid-feedback">{{ $message }}</div>
			@enderror
		</div>
	</div>
	<hr>
	<div class="btn-group">
		<button type="submit" class="btn btn-primary data-submit">
			<i class="bi bi-save"></i> Simpan perubahan
		</button>
		<a href="{{ route('home') }}" class="btn btn-warning">
			<i class="bi bi-arrow-left-circle"></i> Kembali
		</a>
		<button type="button" class="btn btn-danger" id="DelAccountBtn">
			<i class="bi bi-trash3-fill"></i> Hapus Akun
		</button>
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
				$("#form-edit-account :input").removeClass("is-invalid")
					.prop("disabled", true);
				$(".data-submit").prop("disabled", true);
				$('#DelAccountBtn').prop('disabled', true);
				$(".spinner-grow.text-primary").removeClass("d-none");
			},
			complete: function () {
				$("#form-edit-account :input").prop("disabled", false);
				$(".data-submit").prop("disabled", false);
				$('#DelAccountBtn').prop('disabled', false);
				$(".spinner-grow.text-primary").addClass("d-none");
			},
			success: function () {
				$("input[type=password]").val("");
				resetvalidation();
				swal.fire({
					icon: "success",
				  customClass: {
				    popup: 'bg-success',
				    title: 'text-light'
				  },
					title: "Tersimpan"
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
					title: "Gagal simpan",
					text: errmsg,
					icon: "error",
					  customClass: {
					    popup: 'bg-danger',
					    title: 'text-light'
					  }
				});
			}
		});
	};
	$(document).on("click", "#DelAccountBtn", function () {
		confirm.fire({
			title: "Hapus Akun?",
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
					console.error(error);
				}
			}
		}).then((result) => {
			if (result.isConfirmed) {
				swal.fire({
					title: "Akun sudah dihapus",
					icon: "success",
				  customClass: {
				    popup: 'bg-success',
				    title: 'text-light'
				  }
				});
				location.href = "{{ route('login') }}";
			}
		});
	});
</script>
@endsection