@extends('layout')
@section('title','Pengguna')
@section('content')
<div class="modal fade" tabindex="-1" id="modalDelAkun" aria-labelledby="modalDelAkunLabel"
	data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header bg-danger">
				<h5 id="modalDelAkunLabel" class="modal-title text-white">
					Hapus Pengguna?
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<x-caps-lock />
				<p>Anda akan menghapus pengguna <span id="nama-user">...</span>.
					Masukkan password Anda untuk melanjutkan.</p>
				<form id="DelAkunForm">@csrf
					<input type="hidden" name="id" id="delete-id" value="">
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
<div class="modal fade" tabindex="-1" id="modalAddUser" aria-labelledby="modalAddUserLabel" role="dialog"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 id="modalAddUserLabel" class="modal-title">Tambah Pengguna</h5>
				<button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<x-caps-lock />
				<form id="addNewUserForm">@csrf
					<input type="hidden" name="id" id="user_id">
					<div class="form-floating mb-3">
						<input type="text" class="form-control" id="add-user-fullname" placeholder="Admin" name="name"
							aria-label="Admin" pattern="[A-z.,' ]{5,99}" maxlength="99" required />
						<label for="add-user-fullname">Nama Lengkap</label>
						<div class="invalid-feedback" id="name-error"></div>
					</div>
					<div class="form-floating mb-3">
						<input type="email" id="add-user-email" class="form-control" name="email"
							placeholder="mail@example.com" aria-label="mail@example.com" required />
						<label for="add-user-email">Email</label>
						<div class="invalid-feedback" id="email-error"></div>
					</div>
					<div class="form-floating mb-3">
						<input type="password" id="admin-password" class="form-control" minlength="8"
							placeholder="Password Akun Anda" name="current_password" maxlength="20" required />
						<label for="admin-password">Password Anda</label>
						<div class="invalid-feedback" id="current-password-error"></div>
					</div>
					<div class="form-floating mb-3">
						<input type="password" id="add-user-password" name="password" class="form-control"
							placeholder="User Password" minlength="8" maxlength="20" oninput="checkpassword()" required />
						<label for="add-user-password">Password</label>
						<div class="invalid-feedback" id="newpassword-error"></div>
					</div>
					<div class="form-floating mb-3">
						<input type="password" id="confirm-user-password" class="form-control" name="password_confirmation"
							oninput="checkpassword()" placeholder="Ketik ulang Password" minlength="8" maxlength="20"
							required />
						<label for="confirm-user-password">Konfirmasi Password</label>
						<div class="invalid-feedback" id="confirm-password-error"></div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">
					<i class="fas fa-x"></i> Batal
				</button>
				<button type="submit" class="btn btn-primary " form="addNewUserForm">
					<i class="fas fa-floppy-disk"></i> Simpan
				</button>
			</div>
		</div>
	</div>
</div>
<div class="card">
	<div class="card-body">
		<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddUser">
			<i class="fas fa-user-plus"></i> Tambah Pengguna
		</button>
		<table class="table table-bordered" id="table-users" style="width: 100%">
			<thead>
				<tr>
					<th>#</th>
					<th>Nama</th>
					<th>Email</th>
					<th>Aksi</th>
				</tr>
			</thead>
		</table>
	</div>
</div>
@endsection
@section('js')
<script type="text/javascript" src="{{ asset('assets/js/capslock.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/password.js') }}"></script>
<script type="text/javascript">
	let dt_users = $("#table-users"), errmsg;
	const modalForm = $("#modalAddUser"),
	select2 = $("#user-role"),
	userid = {{ auth()->id() }};
	$(document).ready(function () {
		try {
			$.fn.dataTable.ext.errMode = "none";
			dt_users = dt_users.DataTable({
				stateSave: true,
				lengthChange: false,
				serverSide: true,
				processing: true,
				searching: false,
				responsive: true,
				ajax: "{{ route('user.create') }}",
				columns: [
					{ data: "id" }, { data: "name" }, { data: "email" }, { data: "id" }
				],
				columnDefs: [{
					targets: 0,
					render: function (data, type, full, meta) {
						return meta.settings._iDisplayStart + meta.row + 1;
					}
				}, { //Aksi
					orderable: false,
					targets: -1,
					render: function (data, type, full) {
						if (data == userid) {
							return (
								`<a class="btn btn-sm btn-info" href="{{ route('profil.index') }}">` +
								'<i class="fas fa-user-pen"></i>' +
								'</a>');
						}
						return ('<div class="btn-group" role="group">' +
							`<button class="btn btn-sm btn-primary edit-record" data-id="${data}" data-bs-toggle="modal" data-bs-target="#modalAddUser">` +
							'<i class="fas fa-user-pen"></i>' +
							'</button>' +
							`<button class="btn btn-sm btn-danger delete-record" data-id="${data}" data-name="${full["name"]}" data-bs-toggle="modal" data-bs-target="#modalDelAkun">` +
							'<i class="fas fa-trash"></i>' +
							'</button>' +
							"</div>");
					}
				}],
				language: {url: "https://cdn.datatables.net/plug-ins/2.0.0/i18n/id.json"}
			}).on("dt-error", function (e, settings, techNote, message) {
				errorDT(message);
			});
		} catch (dterr) {initError(dterr.message);}
	}).on("click", ".delete-record", function () {
		let user_id = $(this).data("id"), user_name = $(this).data("name");
		$("#delete-id").val(user_id);
		$("#nama-user").text(user_name);
	}).on("click", ".edit-record", function () {
		let user_id = $(this).data("id");
		$("#modalAddUserLabel").text("Edit Pengguna");
		Notiflix.Block.circle('.modal-content','Memuat');
		$.get(`user/${user_id}/edit`, function (data) {
			$("#user_id").val(data.id);
			$("#add-user-fullname").val(data.name);
			$("#add-user-email").val(data.email);
			$('#add-user-password, #confirm-user-password').prop('required', false);
		}).fail(function (xhr, st) {
			if (xhr.status === 302) {
				modalForm.modal("hide");
				Notiflix.Report.info("Ini Akun Anda","Mengalihkan ke halaman Edit Akun");
				location.href = "{{ route('profil.index') }}";
			} else {
				if (xhr.status === 404) {
					dt_users.draw();
					modalForm.modal("hide");
					errmsg = "Pengguna tidak ditemukan";
				} else {
					console.warn(xhr.responseJSON.message ?? st);
					errmsg = `Gagal memuat data: Kesalahan HTTP ${xhr.status} ${xhr.statusText}`;
				}
				Notiflix.Notify.failure(errmsg);
			}
		}).always(function () {Notiflix.Block.remove('.modal-content');});
	});
	$("#addNewUserForm").submit(function(event){
		event.preventDefault();
		$.ajax({
			data: $("#addNewUserForm").serialize(),
			url: "{{ route('user.store') }}",
			type: "POST",
			beforeSend: function () {
				$("#addNewUserForm :input").removeClass("is-invalid");
				Notiflix.Block.circle('.modal-content','Memuat');
			},
			complete: function () {
				Notiflix.Block.remove('.modal-content');
			},
			success: function (status) {
				if ($.fn.DataTable.isDataTable("#table-users")) dt_users.draw();
				modalForm.modal("hide");
				Notiflix.Notify.success(status.message);
			},
			error: function (xhr, st) {
				if (xhr.status === 422) {
					resetvalidation();
					if (typeof xhr.responseJSON.errors.name !== "undefined") {
						$("#add-user-fullname").addClass("is-invalid");
						$("#name-error").text(xhr.responseJSON.errors.name);
					}
					if (typeof xhr.responseJSON.errors.email !== "undefined") {
						$("#add-user-email").addClass("is-invalid");
						$("#email-error").text(xhr.responseJSON.errors.email);
					}
					if (typeof xhr.responseJSON.errors.current_password !== "undefined") {
						$("#admin-password").addClass("is-invalid");
						$("#current-password-error").text(
							xhr.responseJSON.errors.current_password);
					}
					if (typeof xhr.responseJSON.errors.password !== "undefined") {
						$("#add-user-password").addClass("is-invalid");
						$("#newpassword-error").text(xhr.responseJSON.errors.password);
					}
					if (typeof xhr.responseJSON.errors.password_confirmation !==
						"undefined") {
						$("#confirm-user-password").addClass("is-invalid");
						$("#confirm-password-error").text(
							xhr.responseJSON.errors.password_confirmation);
					}
					errmsg = xhr.responseJSON.message;
				} else if (xhr.status === 404) {
					dt_users.draw();
					errmsg = "Pengguna yang Anda edit tidak ditemukan";
				} else {
					console.warn(xhr.responseJSON.message ?? st);
					errmsg = `Gagal: Kesalahan HTTP ${xhr.status} ${xhr.statusText}`;
				}
				Notiflix.Notify.failure(errmsg);
			}
		});
	});
	$("#DelAkunForm").submit(function(e){
		e.preventDefault();
		$.ajax({
			type: "DELETE",
			url: "user/" + $("#delete-id").val(),
			data: $("#DelAkunForm").serialize(),
			beforeSend: function () {
				resetvalidation();
				Notiflix.Block.circle('.modal-content','Menghapus');
			},
			complete: function () {
				Notiflix.Block.remove('.modal-content');
			},
			success: function () {
				dt_users.draw();
				$('#modalDelAkun').modal("hide");
				Notiflix.Notify.success("Berhasil dihapus");
			},
			error: function (xhr, st) {
				if(xhr.status===422) errmsg=xhr.responseJSON.message;
				else if (xhr.status === 404) {
					dt_users.draw();
					errmsg = `Pengguna ${user_name} tidak ditemukan`;
				} else if (xhr.status === 400) errmsg = xhr.responseJSON.message;
				else {
					console.warn(xhr.responseJSON.message ?? st);
					errmsg = `Gagal hapus: Kesalahan HTTP ${xhr.status} ${xhr.statusText}`;
				}
				$("#password-conf").addClass('is-invalid');
				$("#del-error").text(errmsg);
				$("#modalDelAkun").modal("handleUpdate");
				Notiflix.Notify.failure(errmsg);
			}
		});
	});
	modalForm.on("hidden.bs.modal", function () {
		resetvalidation();
		$("#modalAddUserLabel").text("Tambah Pengguna");
		$("#addNewUserForm")[0].reset();
		$('#add-user-password, #confirm-user-password').prop('required', true);
	});
	$("#modalDelAkun").on('hidden.bs.modal',function(){
		resetvalidation();
		$("#DelAkunForm")[0].reset();
		$("#nama-user").text("...");
	});
</script>
@endsection