@extends('layout')
@section('title','Nilai Atribut')
@section('content')
<div class="modal fade" tabindex="-1" id="modalAddNilaiAtribut" aria-labelledby="modalAddNilaiAtributLabel"
	role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 id="modalAddNilaiAtributLabel" class="modal-title">Tambah Nilai Atribut</h5>
				<button type="button" class="btn-close text-reset" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form class="needs-validation" id="addNewNilaiAtributForm">@csrf
					<input type="hidden" name="id" id="attr_id">
					<div class="form-floating mb-4">
						<input type="text" class="form-control" id="attrName" name="name" placeholder="Nama" required />
						<label for="attrName">Nama</label>
						<div class="invalid-tooltip" id="name-error">Masukkan Nama</div>
					</div>
					<div class="form-floating mb-4">
						<select name="atribut_id" class="form-select" id="attrType" required>
							<option value="">Pilih</option>
							@foreach($atribut as $attr)
							<option value="{{$attr->id}}">{{$attr->name}}</option>
							@endforeach
						</select>
						<label for="attrType">Atribut</label>
						<div class="invalid-tooltip" id="type-error">Pilih Atribut</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<div class="spinner-grow text-primary me-3 d-none" role="status">
					<span class="visually-hidden">Menyimpan...</span>
				</div>
				<button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">
					<i class="fas fa-x"></i> Batal
				</button>
				<button type="submit" class="btn btn-primary data-submit" form="addNewNilaiAtributForm">
					<i class="fas fa-floppy-disk"></i> Simpan
				</button>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-4 mb-3">
		<div class="card">
			<div class="card-body">
				<div class="d-flex align-items-start justify-content-between">
					<div class="content-left">
						<span>Jumlah</span>
						<div class="d-flex align-items-end mt-2">
							<h3 class="mb-0 me-2"><span id="total-counter">-</span></h3>
						</div>
					</div>
					<span class="badge bg-primary rounded p-2">
						<i class="fas fa-list-ul"></i>
					</span>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4 mb-3">
		<div class="card">
			<div class="card-body">
				<div class="d-flex align-items-start justify-content-between" data-bs-toggle="tooltip"
					title="Terbanyak per Atribut">
					<div class="content-left">
						<span>Terbanyak</span>
						<div class="d-flex align-items-end mt-2">
							<h3 class="mb-0 me-2"><span id="total-max">-</span></h3>
						</div>
					</div>
					<span class="badge bg-success rounded p-2">
						<i class="fas fa-list"></i>
					</span>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4 mb-3">
		<div class="card">
			<div class="card-body">
				<div class="d-flex align-items-start justify-content-between">
					<div class="content-left">
						<span>Duplikat</span>
						<div class="d-flex align-items-end mt-2">
							<h3 class="mb-0 me-2"><span id="total-duplicate">-</span></h3>
						</div>
					</div>
					<span class="badge bg-warning rounded p-2">
						<i class="fas fa-copy"></i>
					</span>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="card">
	<div class="card-body">
		<button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal"
			data-bs-target="#modalAddNilaiAtribut">
			<i class="fas fa-plus"></i> Tambah Nilai Atribut
		</button>
		<table class="table table-bordered" id="table-atribut" width="100%">
			<thead>
				<tr>
					<th>#</th>
					<th>Nama</th>
					<th>Atribut</th>
					<th>Aksi</th>
				</tr>
			</thead>
		</table>
	</div>
</div>
@endsection
@section('js')
<script type="text/javascript">
	let dt_atribut = $("#table-atribut"), errmsg;
	const modalForm = $("#modalAddNilaiAtribut");
	$(document).ready(function () {
		try {
			$.fn.dataTable.ext.errMode = "none";
			dt_atribut = dt_atribut.DataTable({
				stateSave: true,
				lengthChange: false,
				serverSide: true,
				processing: true,
				responsive: true,
				searching: false,
				ajax: "{{ route('atribut.nilai.create') }}",
				columns: [
					{ data: "id" },
					{ data: "name" },
					{ data: "atribut.name" },
					{ data: "id" }
				],
				columnDefs: [{
					targets: 0,
					searchable: false,
					render: function (data, type, full, meta) {
						return meta.settings._iDisplayStart + meta.row + 1;
					}
				}, { //Aksi
					orderable: false,
					searchable: false,
					targets: -1,
					render: function (data, type, full) {
						return ('<div class="btn-group btn-group-sm" role="group">' +
							`<button class="btn btn-primary edit-record" data-id="${data}" data-bs-toggle="modal" data-bs-target="#modalAddNilaiAtribut">` +
							'<i class="fas fa-pen-to-square"></i>' +
							'</button>' +
							`<button class="btn btn-danger delete-record" data-id="${data}" data-name="${full['name']}">` +
							'<i class="fas fa-trash"></i>' +
							'</button>' +
							"</div>");
					}
				}],
				language: {
					url: "https://cdn.datatables.net/plug-ins/2.0.0/i18n/id.json"
				}
			}).on("dt-error", function (e, settings, techNote, message) {
				errorDT(message, techNote);
			}).on('preXhr', function () {
				$.get("{{ route('atribut.nilai.count') }}", function (data) {
					$('#total-max').text(data.max);
					$("#total-counter").text(data.total);
					$('#total-duplicate').text(data.duplicate);
				}).fail(function (xhr, st) {
					console.warn(xhr.responseJSON.message ?? st);
					notif.error(`Gagal memuat jumlah: Kesalahan HTTP ${xhr.status} ${xhr.statusText}`);
				});
			});
		} catch (dterr) {
			initError(dterr.message);
		}
	}).on("click", ".delete-record", function () {
		let attr_id = $(this).data("id"), attr_name = $(this).data("name");
		confirm.fire({
			titleText: "Hapus Atribut?",
			text: `Anda akan menghapus Nilai Atribut ${attr_name}.`,
			preConfirm: async () => {
				try {
					await $.ajax({
						type: "DELETE",
						headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
						url: '/atribut/nilai/' + attr_id,
						success: function () {
							dt_atribut.draw();
							return "Dihapus";
						},
						error: function (xhr, st) {
							if (xhr.status === 404) {
								dt_atribut.draw();
								errmsg = `Nilai Atribut ${attr_name} tidak ditemukan`;
							} else {
								console.warn(xhr.responseJSON.message ?? st);
								errmsg = `Kesalahan HTTP ${xhr.status} ${xhr.statusText}`;
							}
							return Swal.showValidationMessage('Gagal hapus: ' + errmsg);
						}
					});
				} catch (error) {
					console.error(error.responseJSON);
				}
			}
		}).then(function (result) {
			if (result.isConfirmed) 
				notif.open({ type: "success", message: "Berhasil dihapus" });
		});
	}).on("click", ".edit-record", function () {
		let attr_id = $(this).data("id");
		$("#modalAddNilaiAtributLabel").html("Edit Nilai Atribut");
		formloading("#addNewNilaiAtributForm :input",true);
		$.get(`/atribut/nilai/${attr_id}/edit`, function (data) {
			$("#attr_id").val(data.id);
			$("#attrName").val(data.name);
			$("#attrType").val(data.atribut_id);
		}).fail(function (xhr, st) {
			if (xhr.status === 404) {
				dt_atribut.draw();
				modalForm.modal('hide');
				errmsg = "Atribut tidak ditemukan";
			} else {
				console.warn(xhr.responseJSON.message ?? st);
				errmsg = `Kesalahan HTTP ${xhr.status} ${xhr.statusText}`;
			}
			notif.open({ type: "error", message: "Gagal memuat data: "+errmsg });
		}).always(function () {
			formloading("#addNewNilaiAtributForm :input", false);
		});
	});
	function submitform(ev) {
		ev.preventDefault();
		$.ajax({
			data: $("#addNewNilaiAtributForm").serialize(),
			url: "{{ route('atribut.nilai.store') }}",
			type: "POST",
			beforeSend: function () {
				$("#addNewNilaiAtributForm :input").removeClass("is-invalid");
				$('#modalAddNilaiAtribut :button').prop('disabled',true);
				formloading("#addNewNilaiAtributForm :input", true);
			},
			complete: function () {
				formloading("#addNewNilaiAtributForm :input", false);
				$('#modalAddNilaiAtribut :button').prop('disabled',false);
			},
			success: function (status) {
				if ($.fn.DataTable.isDataTable("#table-atribut")) dt_atribut.draw();
				modalForm.modal("hide");
				notif.open({ type: "success", message: status.message });
			},
			error: function (xhr, st) {
				if (xhr.status === 422) {
					resetvalidation();
					if (typeof xhr.responseJSON.errors.name !== "undefined") {
						$("#attrName").addClass("is-invalid");
						$("#name-error").text(xhr.responseJSON.errors.name);
					}
					if (typeof xhr.responseJSON.errors.atribut_id !== "undefined") {
						$("#attrType").addClass("is-invalid");
						$("#type-error").text(xhr.responseJSON.errors.atribut_id);
					}
					errmsg = xhr.responseJSON.message;
				} else {
					console.warn(xhr.responseJSON.message ?? st);
					errmsg = `Terjadi kesalahan HTTP ${xhr.status} ${xhr.statusText}`;
				}
				notif.open({ type: "error", message: errmsg });
			}
		});
	};
	modalForm.on("hidden.bs.modal", function () {
		resetvalidation();
		$("#modalAddNilaiAtributLabel").html("Tambah Nilai Atribut");
		$("#addNewNilaiAtributForm")[0].reset();
		$("#attr_id").val("");
	});
</script>
@endsection