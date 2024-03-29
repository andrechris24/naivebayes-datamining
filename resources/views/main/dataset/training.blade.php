@extends('layout')
@section('title', 'Data Training')
@section('content')
<div class="modal fade" tabindex="-1" id="modalAddTraining" aria-labelledby="modalAddTrainingLabel"
	data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 id="modalAddTrainingLabel" class="modal-title">Tambah Data Training</h5>
				<button type="button" class="btn-close text-reset" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form class="needs-validation" id="addNewTrainingForm">@csrf
					<input type="hidden" name="id" id="train_id">
					<div class="form-floating mb-3">
						<input type="text" class="form-control" id="trainName" name="nama" placeholder="Nama" required />
						<label for="trainName">Nama</label>
						<div class="invalid-feedback" id="name-error">Masukkan Nama</div>
					</div>
					@foreach ($atribut as $attr)
					<div class="form-floating mb-3" data-bs-toggle="tooltip" title="{{$attr->desc}}">
						@if ($attr->type==='numeric')
						<input type="number" class="form-control" min="0" name="q[{{$attr->slug}}]" placeholder="123"
							id="train-{{$attr->slug}}" required>
						@else
						<select name="q[{{$attr->slug}}]" class="form-select" id="train-{{$attr->slug}}" required>
							<option value="">Pilih</option>
							@foreach ($nilai->where('atribut_id', $attr->id) as $sub)
							<option value="{{$sub->id}}">{{$sub->name}}</option>
							@endforeach
						</select>
						@endif
						<label for="train-{{$attr->slug}}">{{$attr->name}}</label>
						<div class="invalid-feedback" id="{{$attr->slug}}-error">
							{{($attr->type==='numeric'?'Isikan ':'Pilih ').$attr->name}}
						</div>
					</div>
					@endforeach
					<div class="form-floating mb-3">
						<select name="status" class="form-select" id="trainResult" required>
							<option value="">Pilih</option>
							<option value="Layak">Layak</option>
							<option value="Tidak Layak">Tidak Layak</option>
						</select>
						<label for="trainResult">Hasil</label>
						<div class="invalid-feedback" id="result-error">Pilih hasil</div>
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
				<button type="button" class="btn btn-success" data-bs-toggle="modal"
					data-bs-target="#modalImportTraining">
					<i class="bi bi-upload"></i> Upload File
				</button>
				<button type="submit" class="btn btn-primary data-submit" form="addNewTrainingForm">
					<i class="bi bi-save"></i> Simpan
				</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" tabindex="-1" id="modalImportTraining" aria-labelledby="modalImportTrainingLabel"
	data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 id="modalImportTrainingLabel" class="modal-title">Upload Data Training</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="alert alert-info" role="alert">
					<a href="{{route('template-data')}}">Klik disini</a> untuk mendownload template Dataset
				</div>
				<form id="importTrainingData">@csrf
					<input type="file" class="form-control" id="trainData" name="data" data-bs-toggle="tooltip"
						title="Format: xls, xlsx, csv, dan tsv" aria-describedby="importFormats"
						accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.oasis.opendocument.spreadsheet,text/csv,.tsv"
						required>
					<div class="invalid-feedback" id="data-error"></div>
				</form>
			</div>
			<div class="modal-footer">
				<div class="spinner-grow text-success me-3 d-none" role="status">
					<span class="visually-hidden">Mengupload..</span>
				</div>
				<button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">
					<i class="bi bi-x-lg"></i> Batal
				</button>
				<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAddTraining">
					<i class="bi bi-pencil"></i> Input Manual
				</button>
				<button type="submit" class="btn btn-primary data-submit" form="importTrainingData">
					<i class="bi bi-upload"></i> Upload
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
<p>Data Training akan digunakan untuk melatih algoritma Naive Bayes sebagai algoritma klasifikasi.</p>
<div class="card">
	<div class="card-body">
		<div class="btn-group mb-3" role="group" id="spare-button">
			<div class="btn-group" role="group">
				<button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
					aria-expanded="false">
					<i class="bi bi-plus-lg"></i> Tambah Data
				</button>
				<ul class="dropdown-menu">
					<li>
						<a class="dropdown-item" href="#modalAddTraining" data-bs-toggle="modal">
							<i class="bi bi-pencil"></i> Input Manual
						</a>
					</li>
					<li>
						<a class="dropdown-item" href="#modalImportTraining" data-bs-toggle="modal">
							<i class="bi bi-upload"></i> Upload File
						</a>
					</li>
				</ul>
			</div>
			<button type="button" class="btn btn-danger delete-all">
				<i class="bi bi-trash3-fill"></i> Hapus Data
			</button>
			<a href="{{route('training.export')}}" class="btn btn-success">
				<i class="bi bi-download"></i> Ekspor Data
			</a>
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
				searching: false,
				ajax: "{{ route('training.create') }}",
				columns: [
					{ data: "id" },
					{ data: "nama" },
					@foreach ($atribut as $attr)
					{ data: "{{$attr->slug}}" },
					@endforeach
					{ data: "status" },
					{ data: "id" }
				],
				columnDefs: [{
					targets: 0,
					searchable: false,
					render: function (data, type, full, meta) {
						return meta.settings._iDisplayStart + meta.row + 1;
					}
				},
				@foreach ($atribut as $attr)
				{
					targets: 2 + {{$loop->index}},
					render: function(data){
						return data ?? "?";
					}
				},
				@endforeach
				{ //Aksi
					orderable: false,
					searchable: false,
					targets: -1,
					render: function (data, type, full) {
						return ('<div class="btn-group btn-group-sm" role="group">' +
							`<button class="btn btn-primary edit-record" data-id="${data}" data-bs-toggle="modal" data-bs-target="#modalAddTraining">` +
							'<i class="bi bi-pencil-square"></i>' +
							'</button>' +
							`<button class="btn btn-danger delete-record" data-id="${data}" data-name="${full['nama']}">` +
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
							extend: "collection",
							buttons: [{
								text: '<i class="bi bi-pencil"></i> Input Manual',
								attr: {
									"data-bs-toggle": "modal",
									"data-bs-target": "#modalAddTraining"
								}
							}, {
								text: '<i class="bi bi-upload"></i> Upload File',
								attr: {
									"data-bs-toggle": "modal",
									"data-bs-target": "#modalImportTraining"
								}
							}]
						}, {
							text: '<i class="bi bi-trash3-fill"></i> Hapus Data',
							className: "delete-all"
						}, {
							text: '<i class="bi bi-download"></i> Ekspor Data',
							className: 'download-data',
							action: function () {
								location.href = "{{route('training.export')}}";
							}
						}]
					}
				}, drawCallback: function(){
					if(this.api().page.info().recordsTotal===0)
						$('.download-data').prop('disabled',true);
					else $('.download-data').prop('disabled',false);
				}
			}).on("dt-error", function (e, settings, techNote, message) {
				errorDT(message, techNote);
			}).on('preXhr', function () {
				$.get("{{ route('training.count') }}", function (data) {
					$("#total-counter").text(data.total);
					$('#total-duplicate').text(data.duplicate);
				}).fail(function (xhr, st) {
					console.warn(xhr.responseJSON.message ?? st);
					swal.fire({
						icon: 'error',
						titleText: 'Gagal memuat jumlah',
						text: `Kesalahan HTTP ${xhr.status}. ${xhr.statusText}`
					});
				});
			}).on('preInit.dt', removeBtn());
		} catch (dterr) {
			initError(dterr.message);
		}
	}).on("click", ".delete-all", function () {
		confirm.fire({
			titleText: "Hapus semua Data Training?",
			text: 'Anda akan menghapus semua Data Training yang akan mempengaruhi klasifikasi terkait. Probabilitas akan direset!',
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
								`Gagal hapus: Kesalahan HTTP ${xhr.status}. ${xhr.statusText}`);
						}
					});
				} catch (error) {
					console.error(error.responseJSON);
				}
			}
		}).then(function (result) {
			if (result.isConfirmed) {
				swal.fire({
					icon: "success",
					titleText: "Berhasil dihapus"
				});
			}
		});
	}).on("click", ".delete-record", function () {
		let train_id = $(this).data("id"), train_name = $(this).data("name");
		confirm.fire({
			titleText: "Hapus Data Training?",
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
					console.error(error.responseJSON);
				}
			}
		}).then(function (result) {
			if (result.isConfirmed) {
				swal.fire({
					icon: "success",
					titleText: "Berhasil dihapus"
				});
			}
		});
	}).on("click", ".edit-record", function () {
		let train_id = $(this).data("id");
		$("#modalAddTrainingLabel").html("Edit Data Training");
		formloading("#addNewTrainingForm :input",true);
		$('.btn-success').prop('disabled',true);
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
				errmsg = "Data yang Anda cari tidak ditemukan";
			} else {
				console.warn(xhr.responseJSON.message ?? st);
				errmsg = `Kesalahan HTTP ${xhr.status}. ${xhr.statusText}`;
			}
			swal.fire({
				icon: "error",
				titleText: "Gagal memuat data",
				text: errmsg
			});
		}).always(function () {
			$('.btn-success').prop('disabled',false);
			formloading("#addNewTrainingForm :input", false);
		});
	});
	$('#importTrainingData').submit(function(e){//form Upload Data
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
				$("#importTrainingData :input").removeClass("is-invalid");
				$('#modalImportTraining :button').prop('disabled',true);
				formloading("#importTrainingData :input",true);
			},
			complete: function () {
				$('#modalImportTraining :button').prop('disabled',false);
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
					titleText: "Gagal upload",
					text: errmsg,
					icon: "error"
				});
			}
		});
	});
	function submitform(ev) {//form Input Manual
		ev.preventDefault();
		$.ajax({
			data: $("#addNewTrainingForm").serialize(),
			url: "{{ route('training.store') }}",
			type: "POST",
			beforeSend: function () {
				$("#addNewTrainingForm :input").removeClass("is-invalid");
				$('#modalAddTraining').prop('disabled',true);
				formloading("#addNewTrainingForm :input",true);
			},
			complete: function () {
				$('#modalAddTraining').prop('disabled',false);
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
						$("#trainResult").addClass("is-invalid");
						$("#status-error").text(xhr.responseJSON.errors.status);
					}
					errmsg = xhr.responseJSON.message;
				} else {
					console.warn(xhr.responseJSON.message ?? st);
					errmsg = `Kesalahan HTTP ${xhr.status}. ${xhr.statusText}`;
				}
				swal.fire({
					titleText: "Gagal",
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