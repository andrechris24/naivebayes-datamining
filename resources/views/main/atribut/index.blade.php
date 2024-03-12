@extends('layout')
@section('title','Atribut')
@section('content')
<div class="modal fade" tabindex="-1" id="modalAddAtribut" aria-labelledby="modalAddAtributLabel" role="dialog"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 id="modalAddAtributLabel" class="modal-title">Tambah Atribut</h5>
				<button type="button" class="btn-close text-reset" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form class="needs-validation" id="addNewAtributForm">
					@csrf
					<input type="hidden" name="id" id="attr_id">
					<div class="form-floating mb-3">
						<input type="text" class="form-control" id="attrName" name="name" placeholder="Nama" required />
						<label for="attrName">Nama</label>
						<div class="invalid-feedback" id="name-error">
							Masukkan Nama Atribut
						</div>
					</div>
					<div class="form-floating mb-3">
						<select name="type" class="form-select" id="attrType" required>
							<option value="">Pilih</option>
							<option value="numeric">Numerik</option>
							<option value="categorical">Kategoris (Categorical)</option>
						</select>
						<label for="attrType">Tipe Atribut</label>
						<div class="invalid-feedback" id="type-error">
							Pilih tipe atribut
						</div>
					</div>
					<div class="form-floating mb-3">
						<input type="text" class="form-control" id="attrDesc" name="desc" placeholder="Keterangan" />
						<label for="attrDesc">Keterangan</label>
						<div class="invalid-feedback" id="desc-error">
							Masukkan Keterangan
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<div class="spinner-grow text-primary me-3 d-none" role="status">
					<span class="visually-hidden">Menyimpan...</span>
				</div>
				<button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">
					<i class="bi bi-x-lg"></i> Batal
				</button>
				<button type="submit" class="btn btn-primary data-submit" form="addNewAtributForm">
					<i class="bi bi-save"></i> Simpan
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
						<i class="bi bi-list-ul"></i>
					</span>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6 mb-3">
		<div class="card">
			<div class="card-body">
				<div class="d-flex align-items-start justify-content-between" data-bs-toggle="tooltip"
					title="Atribut Kategoris yang tidak digunakan">
					<div class="content-left">
						<span>Tidak digunakan</span>
						<div class="d-flex align-items-end mt-2">
							<h3 class="mb-0 me-2"><span id="total-unused">-</span></h3>
						</div>
					</div>
					<span class="badge bg-danger rounded p-2">
						<i class="bi bi-exclamation-circle-fill"></i>
					</span>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="card">
	<div class="card-body">
		<button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalAddAtribut"
			id="spare-button">
			<i class="bi bi-plus-lg"></i> Tambah Atribut
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
				},{
					targets: 3,
					render: function(data){
						if(data===null) return '-';
						else return data;
					}
				}, { //Aksi
					orderable: false,
					searchable: false,
					targets: -1,
					render: function (data, type, full) {
						return ('<div class="btn-group btn-group-sm" role="group">' +
							`<button class="btn btn-primary edit-record" data-id="${data}" data-bs-toggle="modal" data-bs-target="#modalAddAtribut">` +
							'<i class="bi bi-pencil-square"></i>' +
							'</button>' +
							`<button class="btn btn-danger delete-record" data-id="${data}" data-name="${full['name']}">` +
							'<i class="bi bi-trash3-fill"></i>' +
							'</button>' +
							"</div>");
					}
				}],
				language: {
					url: "https://cdn.datatables.net/plug-ins/2.0.0/i18n/id.json"
				},
				layout: {
					topStart: {
						buttons: [{
							text: '<i class="bi bi-plus-lg"></i> Tambah Atribut',
							className: "add-new",
							attr: {
								"data-bs-toggle": "modal",
								"data-bs-target": "#modalAddAtribut"
							}
						}]
					}
				}
			}).on("error.dt", function (e, settings, techNote, message) {
				errorDT(message, techNote);
			}).on('preXhr', function () {
				$.get("{{ route('atribut.count') }}", function (data) {
					$("#total-counter").text(data.total);
					$('#total-unused').text(data.unused);
				}).fail(function (xhr, st) {
					console.warn(xhr.responseJSON.message ?? st);
					swal.fire({
						icon: 'error',
						title: 'Gagal memuat jumlah',
						text: `Kesalahan HTTP ${xhr.status}. ${xhr.statusText}`,
					  customClass: {
					    popup: 'bg-danger',
					    title: 'text-light'
					  }
					});
				});
			}).on('preInit.dt', removeBtn());
		} catch (dterr) {
			initError(dterr.message);
		}
	}).on("click", ".delete-record", function () {
		let attr_id = $(this).data("id"), attr_name = $(this).data("name");
		confirm.fire({
			title: "Hapus Atribut?",
			text: `Anda akan menghapus Atribut ${attr_name}.`,
			preConfirm: async () => {
				try {
					await $.ajax({
						type: "DELETE",
						headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
						url: 'atribut/' + attr_id,
						success: function () {
							dt_atribut.draw();
							return "Dihapus";
						},
						error: function (xhr, st) {
							if (xhr.status === 404) {
								dt_atribut.draw();
								errmsg = `Atribut ${attr_name} tidak ditemukan`;
							} else {
								console.warn(xhr.responseJSON.message ?? st);
								errmsg = `Kesalahan HTTP ${xhr.status}. ${xhr.statusText}`;
							}
							return Swal.showValidationMessage('Gagal hapus: ' + errmsg);
						}
					});
				} catch (error) {
					console.error(error);
				}
			}
		}).then(function (result) {
			if (result.isConfirmed) {
				swal.fire({
					icon: "success",
				  customClass: {
				    popup: 'bg-success',
				    title: 'text-light'
				  },
					title: "Berhasil dihapus"
				});
			}
		});
	}).on("click", ".edit-record", function () {
		let attr_id = $(this).data("id");
		$("#modalAddAtributLabel").html("Edit Atribut");
		formloading("#addNewAtributForm :input",true);
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
				errmsg = `Kesalahan HTTP ${xhr.status}. ${xhr.statusText}`;
			}
			swal.fire({
				icon: "error",
			  customClass: {
			    popup: 'bg-danger',
			    title: 'text-light'
			  },
				title: "Gagal memuat data",
				text: errmsg
			});
		}).always(function () {
			formloading("#addNewAtributForm :input",false);
		});
	});
	function submitform(ev) {
		ev.preventDefault();
		$.ajax({
			data: $("#addNewAtributForm").serialize(),
			url: "{{ route('atribut.store') }}",
			type: "POST",
			beforeSend: function () {
				formloading("#addNewAtributForm :input",true);
				$("#addNewAtributForm :input").removeClass("is-invalid");
			},
			complete: function () {
				formloading("#addNewAtributForm :input",false);
			},
			success: function (status) {
				if ($.fn.DataTable.isDataTable("#table-atribut")) dt_atribut.draw();
				modalForm.modal("hide");
				swal.fire({
					icon: "success",
				  customClass: {
				    popup: 'bg-success',
				    title: 'text-light'
				  },
					titleText: status.message
				});
			},
			error: function (xhr, st) {
				if (xhr.status === 422) {
					resetvalidation();
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
					errmsg = `Kesalahan HTTP ${xhr.status}. ${xhr.statusText}`;
				}
				swal.fire({
					title: "Gagal",
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
	modalForm.on("hidden.bs.modal", function () {
		resetvalidation();
		$("#modalAddAtributLabel").html("Tambah Atribut");
		$("#addNewAtributForm")[0].reset();
		$("#attr_id").val("");
	});
</script>
@endsection