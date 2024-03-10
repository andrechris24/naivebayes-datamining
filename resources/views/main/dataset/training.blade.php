@extends('layout')
@section('title', 'Data Training')
@section('content')
<div class="modal fade" tabindex="-1" id="modalAddTraining" aria-labelledby="modalAddTrainingLabel"
	role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 id="modalAddTrainingLabel" class="modal-title">Tambah Data Training</h5>
				<button type="button" class="btn-close text-reset" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form class="needs-validation" id="addNewTrainingForm">
					@csrf
					<input type="hidden" name="id" id="train_id">
					<div class="form-floating mb-3">
						<input type="text" class="form-control" id="trainName" name="nama" placeholder="Nama" required />
						<label for="trainName">Nama</label>
						<div class="invalid-feedback" id="name-error">
							Masukkan Nama
						</div>
					</div>
					@foreach ($atribut as $attr)
					<div class="form-floating mb-3" data-bs-toggle="tooltip" title="{{$attr->desc}}">
						@if ($attr->type==='numeric')
						@php($msg="Isikan ")
						<input type="number" class="form-control" min="0" name="q[{{$attr->slug}}]" placeholder="123"
							id="train-{{$attr->slug}}">
						@else
						@php($msg="Pilih ")
						<select name="q[{{$attr->slug}}]" class="form-select" id="train-{{$attr->slug}}">
							<option value="">Pilih</option>
							@foreach ($nilai->where('atribut_id',$attr->id) as $sub)
							<option value="{{$sub->id}}">{{$sub->name}}</option>
							@endforeach
						</select>
						@endif
						<label for="train-{{$attr->slug}}">{{$attr->name}}</label>
						<div class="invalid-feedback" id="{{$attr->slug}}-error">
							{{$msg.$attr->name}}
						</div>
					</div>
					@endforeach
					<div class="form-floating mb-3">
						<select name="status" class="form-select" id="trainResult">
							<option value="" selected>Pilih</option>
							<option value="Layak">Layak</option>
							<option value="Tidak Layak">Tidak Layak</option>
						</select>
						<label for="trainResult">Hasil</label>
						<div class="invalid-feedback" id="result-error">
							Pilih hasil
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
				<button type="submit" class="btn btn-primary data-submit" form="addNewTrainingForm">
					<i class="bi bi-save"></i> Simpan
				</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" tabindex="-1" id="modalImportTraining" aria-labelledby="modalImportTrainingLabel"
	role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 id="modalImportTrainingLabel" class="modal-title">Upload Data Training</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="importTrainingData">
					@csrf
					<input type="file" class="form-control" id="trainData" name="data"  aria-describedby="importFormats" accept=".csv, .tsv, .ods, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
					<div id="importFormats" class="form-text">
					  Format yang diperbolehkan: .xls, .xlsx, .csv, .tsv
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<div class="spinner-grow text-success me-3 d-none" role="status">
					<span class="visually-hidden">Mengupload..</span>
				</div>
				<button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">
					<i class="bi bi-x-lg"></i> Batal
				</button>
				<button type="submit" class="btn btn-primary data-submit" form="importTrainingData">
					<i class="bi bi-save"></i> Unggah
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
				<div class="d-flex align-items-start justify-content-between">
					<div class="content-left">
						<span>Duplikat</span>
						<div class="d-flex align-items-end mt-2">
							<h3 class="mb-0 me-2"><span id="total-duplicate">-</span></h3>
						</div>
					</div>
					<span class="badge bg-warning rounded p-2">
						<i class="bi bi-copy"></i>
					</span>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="card">
	<div class="card-body">
		<div class="btn-group" role="group" id="spare-button">
			<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddTraining">
				<i class="bi bi-plus-lg"></i> Tambah Data
			</button>
			<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalImportTraining">
				<i class="bi bi-upload"></i> Upload Data
			</button>
			<button type="button" class="btn btn-danger delete-all">
				<i class="bi bi-trash3-fill"></i> Hapus semua data
			</button>
		</div>
		<table class="table table-bordered" id="table-training" width="100%">
			<thead>
				<tr>
					<th>#</th>
					<th>Nama</th>
					@foreach ($atribut as $attr)
					<th data-bs-toggle="tooltip" title="{{$attr->desc}}">
						{{$attr->name}}
					</th>
					@endforeach
					<th>Status</th>
					<th>Aksi</th>
				</tr>
			</thead>
		</table>
	</div>
</div>
@endsection
@section('js')
<script type="text/javascript">
	let dt_training = $("#table-training"), errmsg;
	const modalForm = $("#modalAddTraining");
	$(document).ready(function () {
		try {
			$.fn.dataTable.ext.errMode = "none";
			dt_training = dt_training.DataTable({
				stateSave: true,
				lengthChange: false,
				serverSide: true,
				processing: true,
				responsive: true,
				ajax: "{{ route('training.create') }}",
				columns: [
					{ data: "id" },
					{ data: "nama" },
					@foreach ($atribut as $attr)
						{data: "{{$attr->slug}}"},
					@endforeach
					{ data: "status" },
					{ data: "id" }
				],
				columnDefs: [{
					targets: 0,
					render: function (data, type, full, meta) {
						return meta.settings._iDisplayStart + meta.row + 1;
					}
				},
				@foreach ($atribut as $attr)
					{
						targets: 2+{{$loop->index}},
						render:function(data){
							console.log(data);
							if(data===null) return '?';
							else return data;
						}
					},
				@endforeach
				{ //Aksi
					orderable: false,
					targets: -1,
					render: function (data, type, full) {
						return ('<div class="btn-group btn-group-sm" role="group">' +
							`<button class="btn btn-primary edit-record" data-id="${data}" data-bs-toggle="modal" data-bs-target="#modalAddTraining">` +
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
							text: '<i class="bi bi-plus-lg"></i> Tambah Data',
							className: "add-new",
							attr: {
								"data-bs-toggle": "modal",
								"data-bs-target": "#modalAddTraining"
							}
						}, {
							text: '<i class="bi bi-upload"></i> Upload Data',
							attr: {
								"data-bs-toggle": "modal",
								"data-bs-target": "#modalImportTraining"
							}
						},{
							text: '<i class="bi bi-trash3-fill"></i> Hapus semua data',
							className: "delete-all"
						}, {
							extend: "collection",
							text: '<i class="bi bi-download"></i> Ekspor Data',
							buttons: [{
								extend: "excel",
								title: "Data Training",
								text: '<i class="bi bi-file-earmark-spreadsheet"></i> Excel',
								exportOptions: {
									columns: ':not(:last-child)',
								}
							}, {
								extend: "pdf",
								title: "Data Training",
								text: '<i class="bi bi-file-earmark-pdf"></i> PDF',
								exportOptions: {
									columns: ':not(:last-child)',
								}
							}]
						}]
					}
				}
			}).on("error.dt", function (e, settings, techNote, message) {
				errorDT(message, techNote);
			}).on('preXhr', function () {
				$.get("{{ route('training.count') }}", function (data) {
					$("#total-counter").text(data.total);
					$('#total-duplicate').text(data.duplicate);
				}).fail(function (xhr, st) {
					console.warn(xhr.responseJSON.message ?? st);
					swal.fire({
						icon: 'error',
						title: 'Gagal memuat jumlah',
						text: `Kesalahan HTTP ${xhr.status}. ${xhr.statusText}`
					});
				});
			}).on('preInit.dt', removeBtn());
		} catch (dterr) {
			initError(dterr.message);
		}
	}).on("click", ".delete-all", function () {
		confirm.fire({
			title: "Hapus semua Data Training?",
			text: 'Anda akan menghapus semua Data Training yang akan mempengaruhi klasifikasi terkait.',
			preConfirm: async () => {
				try {
					await $.ajax({
						type: "DELETE",
						headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
						url: "{{route('training.clear')}}",
						success: function () {
							if ($.fn.DataTable.isDataTable("#table-training")) 
								dt_training.draw();
							return "Dihapus";
						},
						error: function (xhr, st) {
							console.warn(xhr.responseJSON.message ?? st);
							return Swal.showValidationMessage(
								`Gagal hapus: Kesalahan HTTP ${xhr.status}. ${xhr.statusText}`
							);
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
					title: "Berhasil dihapus"
				});
			}
		});
	}).on("click", ".delete-record", function () {
		let train_id = $(this).data("id"), train_name = $(this).data("name");
		confirm.fire({
			title: "Hapus Data Training?",
			text: `Anda akan menghapus Data Training ${train_name}.`,
			preConfirm: async () => {
				try {
					await $.ajax({
						type: "DELETE",
						headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
						url: 'training/' + train_id,
						success: function () {
							dt_training.draw();
							return "Dihapus";
						},
						error: function (xhr, st) {
							if (xhr.status === 404) {
								dt_training.draw();
								errmsg = `Data Training ${train_name} tidak ditemukan`;
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
					title: "Berhasil dihapus"
				});
			}
		});
	}).on("click", ".edit-record", function () {
		let train_id = $(this).data("id");
		$("#modalAddTrainingLabel").html("Edit Data Training");
		formloading("#addNewTrainingForm :input",true);
		$.get(`training/${train_id}/edit`, function (data) {
			$("#train_id").val(data.id);
			$("#trainName").val(data.nama);
			$('#trainResult').val(data.status);
			@foreach($atribut as $attr)
			$("#train-{{$attr->slug}}").val(data.{{$attr->slug}});
			@endforeach
		}).fail(function (xhr, st) {
			if (xhr.status === 404) {
				dt_training.draw();
				modalForm.modal('hide');
				errmsg = "Data Training tidak ditemukan";
			} else {
				console.warn(xhr.responseJSON.message ?? st);
				errmsg = `Kesalahan HTTP ${xhr.status}. ${xhr.statusText}`;
			}
			swal.fire({
				icon: "error",
				title: "Gagal memuat data",
				text: errmsg
			});
		}).always(function () {
			formloading("#addNewTrainingForm :input",false);
		});
	});
	$('#importTrainingData').submit(function(e){
		e.preventDefault();
		$.ajax({
        type: "POST",
        url: "{{route('training.import')}}",
        dataType: 'JSON',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function () {
					formloading("#importTrainingData :input",true);
					$("#importTrainingData :input").removeClass("is-invalid");
				},
				complete: function () {
					formloading("#importTrainingData :input",false);
				},
				success: function (status) {
					if ($.fn.DataTable.isDataTable("#table-training")) dt_training.draw();
					$('#modalImportTraining').modal("hide");
					swal.fire({
						icon: "success",
						titleText: "Berhasil diupload"
					});
				},
				error: function (xhr, st) {
					if (xhr.status === 422) {
						resetvalidation();
						if (typeof xhr.responseJSON.errors.data !== "undefined") {
							$("#trainData").addClass("is-invalid");
							$("#data-error").text(xhr.responseJSON.errors.data);
						}
						errmsg = xhr.responseJSON.message;
					} else {
						console.warn(xhr.responseJSON.message ?? st);
						errmsg = `Kesalahan HTTP ${xhr.status}. ${xhr.statusText}`;
					}
					swal.fire({
						title: "Gagal",
						text: errmsg,
						icon: "error"
					});
				}
    });
	});
	function submitform(ev) {
		ev.preventDefault();
		$.ajax({
			data: $("#addNewTrainingForm").serialize(),
			url: "{{ route('training.store') }}",
			type: "POST",
			beforeSend: function () {
				formloading("#addNewTrainingForm :input",true);
				$("#addNewTrainingForm :input").removeClass("is-invalid");
			},
			complete: function () {
				formloading("#addNewTrainingForm :input",false);
			},
			success: function (status) {
				if ($.fn.DataTable.isDataTable("#table-training")) dt_training.draw();
				modalForm.modal("hide");
				swal.fire({
					icon: "success",
					titleText: status.message
				});
			},
			error: function (xhr, st) {
				if (xhr.status === 422) {
					resetvalidation();
					if (typeof xhr.responseJSON.errors.nama !== "undefined") {
						$("#trainName").addClass("is-invalid");
						$("#name-error").text(xhr.responseJSON.errors.nama);
					}
					@foreach($atribut as $attr)
					if (typeof xhr.responseJSON.errors.{{$attr->slug}} !== "undefined") {
						$("#train-{{$attr->slug}}").addClass("is-invalid");
						$("#{{$attr->slug}}-error").text(xhr.responseJSON.errors.{{$attr->slug}});
					}
					@endforeach
					if (typeof xhr.responseJSON.errors.status !== "undefined") {
						$("#trainName").addClass("is-invalid");
						$("#status-error").text(xhr.responseJSON.errors.status);
					}
					errmsg = xhr.responseJSON.message;
				} else {
					console.warn(xhr.responseJSON.message ?? st);
					errmsg = `Kesalahan HTTP ${xhr.status}. ${xhr.statusText}`;
				}
				swal.fire({
					title: "Gagal",
					text: errmsg,
					icon: "error"
				});
			}
		});
	};
	modalForm.on("hidden.bs.modal", function () {
		resetvalidation();
		$("#modalAddTrainingLabel").html("Tambah Data Training");
		$("#addNewTrainingForm")[0].reset();
		$("#train_id").val("");
	});
</script>
@endsection