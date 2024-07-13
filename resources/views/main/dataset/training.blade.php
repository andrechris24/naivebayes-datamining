@extends('layout')
@section('title', 'Data Training')
@section('content')
<div class="modal fade" tabindex="-1" id="modalAddTraining" aria-labelledby="modalAddTrainingLabel"
	data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 id="modalAddTrainingLabel" class="modal-title">
					Tambah Data Training
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="addNewTrainingForm">@csrf
					<input type="hidden" name="id" id="train_id">
					<div class="form-floating mb-3">
						<input type="text" class="form-control" id="trainName" name="nama" placeholder="Nama" required />
						<label for="trainName">Nama</label>
						<div class="invalid-feedback" id="name-error"></div>
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
						<div class="invalid-feedback" id="{{$attr->slug}}-error"></div>
					</div>
					@endforeach
					<div class="form-floating mb-3">
						<select name="status" class="form-select" id="trainResult" required>
							<option value="">Pilih</option>
							<option value="1">{{$hasil[true]}}</option>
							<option value="0">{{$hasil[false]}}</option>
						</select>
						<label for="trainResult">Status</label>
						<div class="invalid-feedback" id="result-error"></div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">
					<i class="fas fa-x"></i> Batal
				</button>
				<button type="button" class="btn btn-success" data-bs-toggle="modal"
					data-bs-target="#modalImportTraining">
					<i class="fas fa-upload"></i> Upload File
				</button>
				<button type="submit" class="btn btn-primary" form="addNewTrainingForm">
					<i class="fas fa-floppy-disk"></i> Simpan
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
				<h5 id="modalImportTrainingLabel" class="modal-title">
					Upload Data Training
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="alert alert-info" role="alert">
					<i class="fas fa-info-circle"></i>
					<a href="{{route('template-data')}}" class="alert-link">Klik disini</a>
					untuk mendownload template Dataset
				</div>
				<form id="importTrainingData" enctype="multipart/form-data">@csrf
					<input type="file" class="form-control" id="trainData" name="data" data-bs-toggle="tooltip"
						title="Format: xls, xlsx, csv, dan tsv" aria-describedby="importFormats"
						accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.oasis.opendocument.spreadsheet,text/csv,.tsv"
						required>
					<div class="invalid-feedback" id="data-error"></div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">
					<i class="fas fa-x"></i> Batal
				</button>
				<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAddTraining">
					<i class="fas fa-pen"></i> Input Manual
				</button>
				<button type="submit" class="btn btn-primary" form="importTrainingData">
					<i class="fas fa-upload"></i> Upload
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
					title="Jumlah Data Training dengan nama duplikat">
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
	<div class="col-md-4 mb-3">
		<div class="card">
			<div class="card-body">
				<div class="d-flex align-items-start justify-content-between" data-bs-toggle="tooltip"
					title="Jumlah kolom kosong">
					<div class="content-left">
						<span>Kosong</span>
						<div class="d-flex align-items-end mt-2">
							<h3 class="mb-0 me-2"><span id="total-missing">-</span></h3>
						</div>
					</div>
					<span class="badge bg-danger rounded p-2">
						<i class="fas fa-exclamation-circle"></i>
					</span>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="alert alert-info alert-dismissible" role="alert">
	<p>Data Training (Data Latih) digunakan untuk melatih algoritma klasifikasi Naive Bayes.
		Jika Anda melakukan perubahan pada Data Training, Probabilitas akan direset secara otomatis.</p>
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<div class="card">
	<div class="card-body">
		<div class="btn-group mb-2" role="group">
			<div class="btn-group" role="group">
				<button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
					aria-expanded="false">
					<i class="fas fa-plus"></i> Tambah Data
					<i class="fa-solid fa-caret-down"></i>
				</button>
				<ul class="dropdown-menu">
					<li>
						<a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalAddTraining">
							<i class="fas fa-pen"></i> Input Manual
						</a>
					</li>
					<li>
						<a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalImportTraining">
							<i class="fas fa-upload"></i> Upload File
						</a>
					</li>
				</ul>
			</div>
			<button type="button" class="btn btn-danger" id="delete-all" disabled>
				<i class="fas fa-trash"></i> Hapus Data
			</button>
			<a href="{{route('training.export')}}" class="btn btn-success disabled" id="dlBtn">
				<i class="fas fa-download"></i> Ekspor
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
	let dt_training = $("#table-training"), errmsg="";
	const modalForm = $("#modalAddTraining"),modalImport=$('#modalImportTraining');
	$(document).ready(function () {
		try {
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
				], columnDefs: [{
					targets: 0,
					render: function (data, type, full, meta) {
						return meta.settings._iDisplayStart + meta.row + 1;
					}
				},
				@foreach ($atribut as $attr)
				{
					targets: 2 + {{$loop->index}},
					render: function(data) {
						return data??"?";
					}
				},
				@endforeach
				{ //Aksi
					orderable: false,
					className: "text-center",
					targets: -1,
					render: function (data, type, full) {
						return ('<div class="btn-group btn-group-sm" role="group">' +
							`<button class="btn btn-primary edit-record" data-id="${data}" data-bs-toggle="modal" data-bs-target="#modalAddTraining">` +
							'<i class="fas fa-pen-to-square"></i>' +
							'</button>' +
							`<button class="btn btn-danger delete-record" data-id="${data}" data-name="${full['nama']}">` +
							'<i class="fas fa-trash"></i>' +
							'</button>' +
							"</div>");
					}
				}], language: {
					url: "https://cdn.datatables.net/plug-ins/2.0.0/i18n/id.json"
				}, drawCallback: function(){
					let total=this.api().page.info().recordsTotal;
					if(total===0){
						$('#dlBtn').addClass('disabled');
						$("#delete-all").prop('disabled',true);
					}	else {
						$('#dlBtn').removeClass('disabled');
						$("#delete-all").prop('disabled',false);
					}
					$("#total-counter").text(total);
					$.get("{{ route('training.count') }}", function (data) {
						$('#total-duplicate').text(data.duplicate);
						$("#total-missing").text(data.empty);
					}).fail(function (xhr, st) {
						console.warn(xhr.responseJSON.message ?? st);
						iziToast.error({
							title: "Gagal memuat jumlah",
							message: `Kesalahan HTTP ${xhr.status} ${xhr.statusText}`,
							displayMode: 2
						});
					});
				}
			}).on("dt-error", function (e, settings, techNote, message) {
				errorDT(message);
			});
		} catch (dterr) {
			initError(dterr.message);
		}
	}).on("click", "#delete-all", function () {
		iziToast.question({
			timeout: 20000,
			overlay: true,
			title: "Hapus semua Data Training?",
			message: 'Anda akan menghapus semua Data Training.',
			position: 'center',
			buttons: [
				['<button><b>Hapus</b></button>', function (instance, toast) {
					instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
					$.LoadingOverlay('show');
					$.ajax({
						type: "DELETE",
						headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
						url: "{{route('training.clear')}}",
						complete:function(){
							$.LoadingOverlay('hide');
						}, success: function () {
							if ($.fn.DataTable.isDataTable("#table-training"))
								dt_training.draw();
							iziToast.success({
								title: "Semua data berhasil dihapus",displayMode: 2
							});
						}, error: function (xhr, st) {
							console.warn(xhr.responseJSON.message ?? st);
							iziToast.error({
								title: "Gagal hapus",
								message: `Kesalahan HTTP ${xhr.status} ${xhr.statusText}`,
								displayMode: 2
							});
						}
					});
				}, true],
				['<button>Batal</button>', function (instance, toast) {
					instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
				}]
			]
		});
	}).on("click", ".delete-record", function () {
		let train_id = $(this).data("id"), train_name = $(this).data("name");
		iziToast.question({
			timeout: 20000,
			overlay: true,
			title: "Hapus Data Training?",
			message: `Anda akan menghapus Data Training ${train_name}.`,
			position: 'center',
			buttons: [
				['<button><b>Hapus</b></button>', function (instance, toast) {
					instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
					$.LoadingOverlay('show');
					$.ajax({
						type: "DELETE",
						headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
						url: 'training/' + train_id,
						complete:function(){
							$.LoadingOverlay('hide');
						}, success: function () {
							dt_training.draw();
							iziToast.success({title: "Berhasil dihapus",displayMode: 2});
						}, error: function (xhr, st) {
							if (xhr.status === 404) {
								dt_training.draw();
								errmsg = `Data Training ${train_name} tidak ditemukan`;
							} else {
								console.warn(xhr.responseJSON.message ?? st);
								errmsg = `Kesalahan HTTP ${xhr.status} ${xhr.statusText}`;
							}
							iziToast.error({title: "Gagal hapus",message: errmsg,displayMode: 2});
						}
					});
				}, true],
				['<button>Batal</button>', function (instance, toast) {
					instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
				}]
			]
		});
	}).on("click", ".edit-record", function () {
		let train_id = $(this).data("id");
		$("#modalAddTrainingLabel").text("Edit Data Training");
		$(modalForm).LoadingOverlay('show');
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
				errmsg = `Kesalahan HTTP ${xhr.status} ${xhr.statusText}`;
			}
			iziToast.error({title: "Gagal memuat data",message: errmsg,displayMode: 2});
		}).always(function () {
			$(modalForm).LoadingOverlay('hide');
		});
	});
	$('#importTrainingData').on("submit",function(e){//form Upload Data
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
				resetvalidation();
				modalImport.LoadingOverlay('show');
			}, complete: function () {
				modalImport.LoadingOverlay('hide');
			}, success: function (status) {
				if ($.fn.DataTable.isDataTable("#table-training")) dt_training.draw();
				modalImport.modal("hide");
				iziToast.success({title: "Berhasil diupload",displayMode: 2});
			}, error: function (xhr, st) {
				$("#trainData").addClass("is-invalid");
				$("#data-error").text(xhr.responseJSON.message);
				if (xhr.status === 422) errmsg = xhr.responseJSON.message;
				else {
					console.warn(xhr.responseJSON.message ?? st);
					errmsg = `Kesalahan HTTP ${xhr.status} ${xhr.statusText}`;
				}
				modalImport.modal("handleUpdate");
				iziToast.error({title: "Gagal upload",message: errmsg,displayMode: 2});
			}
		});
	});
	$("#addNewTrainingForm").on("submit",function (ev) {//form Input Manual
		ev.preventDefault();
		$.ajax({
			data: $("#addNewTrainingForm").serialize(),
			url: "{{ route('training.store') }}",
			type: "POST",
			beforeSend: function () {
				resetvalidation();
				$(modalForm).LoadingOverlay('show');
			}, complete: function () {
				$(modalForm).LoadingOverlay('hide');
			}, success: function (status) {
				if ($.fn.DataTable.isDataTable("#table-training")) dt_training.draw();
				modalForm.modal("hide");
				iziToast.success({title: status.message,displayMode: 2});
			}, error: function (xhr, st) {
				if (xhr.status === 422) {
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
					modalForm.modal("handleUpdate");
				} else {
					console.warn(xhr.responseJSON.message ?? st);
					errmsg = `Kesalahan HTTP ${xhr.status} ${xhr.statusText}`;
				}
				iziToast.error({title: "Gagal",message: errmsg,displayMode: 2});
			}
		});
	});
	modalForm.on("hidden.bs.modal", function () {
		resetForm("#addNewTrainingForm");
		$("#modalAddTrainingLabel").text("Tambah Data Training");
	});
	modalImport.on('hidden.bs.modal',function(){
		resetForm("#importTrainingData");
	});
</script>
@endsection