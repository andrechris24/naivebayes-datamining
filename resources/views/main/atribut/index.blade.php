@extends('layout')
@section('title','Atribut')
@section('content')
<div class="modal fade" tabindex="-1" id="modalAddAtribut" aria-labelledby="modalAddAtributLabel" role="dialog"
	aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 id="modalAddAtributLabel" class="modal-title">Tambah Atribut</h5>
				<button type="button" class="btn-close text-reset" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="addNewAtributForm">@csrf
					<input type="hidden" name="id" id="attr_id">
					<div class="form-floating mb-3">
						<input type="text" class="form-control" id="attrName" name="name" placeholder="Nama" required />
						<label for="attrName">Nama</label>
						<div class="invalid-feedback" id="name-error"></div>
					</div>
					<div class="form-floating mb-3">
						<select name="type" class="form-select" id="attrType" required>
							<option value="">Pilih</option>
							<option value="numeric">Numerik</option>
							<option value="categorical">Kategorikal</option>
						</select>
						<label for="attrType">Tipe Atribut</label>
						<div class="invalid-feedback" id="type-error"></div>
					</div>
					<div class="form-floating mb-3">
						<input type="text" class="form-control" id="attrDesc" name="desc" placeholder="Keterangan" />
						<label for="attrDesc">Keterangan</label>
						<div class="invalid-feedback" id="desc-error"></div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">
					<i class="fas fa-x"></i> Batal
				</button>
				<button type="submit" class="btn btn-primary" form="addNewAtributForm">
					<i class="fas fa-floppy-disk"></i> Simpan
				</button>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6 mb-3">
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
	<div class="col-sm-6 mb-3">
		<div class="card">
			<div class="card-body">
				<div class="d-flex align-items-start justify-content-between" data-bs-toggle="tooltip"
					title="Atribut Kategorikal yang tidak digunakan">
					<div class="content-left">
						<span>Tidak digunakan</span>
						<div class="d-flex align-items-end mt-2">
							<h3 class="mb-0 me-2"><span id="total-unused">-</span></h3>
						</div>
					</div>
					<span class="badge bg-danger rounded p-2">
						<i class="fas fa-circle-exclamation"></i>
					</span>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="card">
	<div class="card-body">
		<button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#modalAddAtribut">
			<i class="fas fa-plus"></i> Tambah Atribut
		</button>
		<table class="table table-bordered" id="table-atribut" width="100%">
			<thead>
				<tr>
					<th>#</th>
					<th>Nama</th>
					<th>Tipe Atribut</th>
					<th>Keterangan</th>
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
	const modalForm = $("#modalAddAtribut");
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
				ajax: "{{ route('atribut.create') }}",
				columns: [
					{ data: "id" },
					{ data: "name" },
					{ data: "type" },
					{ data: "desc" },
					{ data: "id" }
				],
				columnDefs: [{
					targets: 0,
					searchable: false,
					render: function (data, type, full, meta) {
						return meta.settings._iDisplayStart + meta.row + 1;
					}
				}, {
					targets: 3,
					render: function(data){
						if(data === null) return '-';
						else return data;
					}
				}, { //Aksi
					orderable: false,
					searchable: false,
					targets: -1,
					render: function (data, type, full) {
						return ('<div class="btn-group btn-group-sm" role="group">' +
							`<button class="btn btn-primary edit-record" data-id="${data}" data-bs-toggle="modal" data-bs-target="#modalAddAtribut">` +
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
			}).on('xhr', function () {
				$.get("{{ route('atribut.count') }}", function (data) {
					$("#total-counter").text(data.total);
					$('#total-unused').text(data.unused);
				}).fail(function (xhr, st) {
					console.warn(xhr.responseJSON.message ?? st);
					Notiflix.Notify.failure(
						`Gagal memuat jumlah: Kesalahan HTTP ${xhr.status} ${xhr.statusText}`
					);
				});
			});
		} catch (dterr) {
			initError(dterr.message);
		}
	}).on("click", ".delete-record", function () {
		let attr_id = $(this).data("id"), attr_name = $(this).data("name");
		Notiflix.Confirm.show(
			"Hapus Atribut?",
			`Anda akan menghapus Atribut ${attr_name}.`,
			'Ya',
			'Tidak',
			function () {
				$.ajax({
					type: "DELETE",
					headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
					url: 'atribut/' + attr_id,
					beforeSend: function(){
						Notiflix.Loading.standard("Menghapus");
					},
					complete: function(){
						Notiflix.Loading.remove();
					},
					success: function () {
						dt_atribut.draw();
						Notiflix.Notify.success("Berhasil dihapus");
					},
					error: function (xhr, st) {
						if (xhr.status === 404) {
							dt_atribut.draw();
							errmsg = `Atribut ${attr_name} tidak ditemukan`;
						} else {
							console.warn(xhr.responseJSON.message ?? st);
							errmsg = `Kesalahan HTTP ${xhr.status} ${xhr.statusText}`;
						}
						Notiflix.Notify.failure('Gagal hapus: ' + errmsg);
					}
				});
			}
		);
	}).on("click", ".edit-record", function () {
		let attr_id = $(this).data("id");
		$("#modalAddAtributLabel").html("Edit Atribut");
		Notiflix.Block.standard('.modal-content','Memuat');
		$.get(`atribut/${attr_id}/edit`, function (data) {
			$("#attr_id").val(data.id);
			$("#attrName").val(data.name);
			$('#attrDesc').val(data.desc);
			$("#attrType").val(data.type);
		}).fail(function (xhr, st) {
			if (xhr.status === 404) {
				dt_atribut.draw();
				modalForm.modal('hide');
				errmsg = "Atribut tidak ditemukan";
			} else {
				console.warn(xhr.responseJSON.message ?? st);
				errmsg = `Kesalahan HTTP ${xhr.status} ${xhr.statusText}`;
			}
			Notiflix.Notify.failure("Gagal memuat data: "+errmsg);
		}).always(function () {
			Notiflix.Block.remove('.modal-content');
		});
	});
	$("#addNewAtributForm").submit(function (ev) {
		ev.preventDefault();
		$.ajax({
			data: $("#addNewAtributForm").serialize(),
			url: "{{ route('atribut.store') }}",
			type: "POST",
			beforeSend: function () {
				resetvalidation();
				Notiflix.Block.standard('.modal-content','Menyimpan');
			},
			complete: function () {
				Notiflix.Block.remove('.modal-content');
			},
			success: function (status) {
				if ($.fn.DataTable.isDataTable("#table-atribut")) dt_atribut.draw();
				modalForm.modal("hide");
				Notiflix.Notify.success(status.message);
			},
			error: function (xhr, st) {
				if (xhr.status === 422) {
					if (typeof xhr.responseJSON.errors.name !== "undefined") {
						$("#attrName").addClass("is-invalid");
						$("#name-error").text(xhr.responseJSON.errors.name);
					}
					if (typeof xhr.responseJSON.errors.type !== "undefined") {
						$("#attrType").addClass("is-invalid");
						$("#type-error").text(xhr.responseJSON.errors.type);
					}
					if (typeof xhr.responseJSON.errors.desc !== "undefined") {
						$("#attrDesc").addClass("is-invalid");
						$("#desc-error").text(xhr.responseJSON.errors.desc);
					}
					errmsg = xhr.responseJSON.message;
				} else {
					console.warn(xhr.responseJSON.message ?? st);
					errmsg = `Terjadi kesalahan HTTP ${xhr.status} ${xhr.statusText}`;
				}
				Notiflix.Notify.failure(errmsg);
			}
		});
	});
	modalForm.on("hidden.bs.modal", function () {
		resetvalidation();
		$("#modalAddAtributLabel").html("Tambah Atribut");
		$("#addNewAtributForm")[0].reset();
		$("#attr_id").val("");
	});
</script>
@endsection