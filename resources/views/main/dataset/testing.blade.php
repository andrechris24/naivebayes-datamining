@extends('layout')
@section('title', 'Data Testing')
@section('content')
<div class="modal fade" tabindex="-1" id="modalAddTesting" aria-labelledby="modalAddTestingLabel" role="dialog"
	aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 id="modalAddTestingLabel" class="modal-title">Tambah Data Testing</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="addNewTestingForm">@csrf
					<input type="hidden" name="id" id="test_id">
					<div class="form-floating mb-3">
						<input type="text" class="form-control" id="testName" name="nama" placeholder="Nama" required />
						<label for="testName">Nama</label>
						<div class="invalid-feedback" id="name-error"></div>
					</div>
					@foreach ($atribut as $attr)
					<div class="form-floating mb-3" data-bs-toggle="tooltip" title="{{$attr->desc}}">
						@if ($attr->type === 'numeric')
						<input type="number" class="form-control" min="0" name="q[{{$attr->slug}}]"
							id="test-{{$attr->slug}}" placeholder="123" required>
						@else
						<select name="q[{{$attr->slug}}]" class="form-select" id="test-{{$attr->slug}}" required>
							<option value="">Pilih</option>
							@foreach ($nilai->where('atribut_id', $attr->id) as $sub)
							<option value="{{$sub->id}}">{{$sub->name}}</option>
							@endforeach
						</select>
						@endif
						<label for="test-{{$attr->slug}}">{{$attr->name}}</label>
						<div class="invalid-feedback" id="{{$attr->slug}}-error"></div>
					</div>
					@endforeach
					<div class="form-floating mb-3">
						<select name="status" class="form-select" id="testResult" required>
							<option value="">Pilih</option>
							<option value="1">{{$hasil[true]}}</option>
							<option value="0">{{$hasil[false]}}</option>
							<option value="auto" @if($calculated===0) disabled @endif>
								Pilih otomatis
							</option>
						</select>
						<label for="testResult">Status</label>
						<div class="invalid-feedback" id="result-error"></div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">
					<i class="fas fa-x"></i> Batal
				</button>
				<button type="button" class="btn btn-success" data-bs-toggle="modal"
					data-bs-target="#modalImportTesting">
					<i class="fas fa-upload"></i> Upload File
				</button>
				<button type="submit" class="btn btn-primary" form="addNewTestingForm">
					<i class="fas fa-floppy-disk"></i> Simpan
				</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" tabindex="-1" id="modalImportTesting" aria-labelledby="modalImportTestingLabel"
	data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 id="modalImportTestingLabel" class="modal-title">
					Upload Data Testing
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="alert alert-info" role="alert">
					<i class="fas fa-info-circle"></i>
					<a href="{{route('template-data')}}" class="alert-link">Klik disini</a>
					untuk mendownload template Dataset
				</div>
				<form id="importTestingData" enctype="multipart/form-data">@csrf
					<input type="file" class="form-control" id="testData" name="data" aria-describedby="importFormats"
						data-bs-toggle="tooltip" title="Format: xls, xlsx, csv, dan tsv"
						accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.oasis.opendocument.spreadsheet,text/csv,.tsv"
						required>
					<div class="invalid-feedback" id="data-error"></div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">
					<i class="fas fa-x"></i> Batal
				</button>
				<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAddTesting">
					<i class="fas fa-pen"></i> Input Manual
				</button>
				<button type="submit" class="btn btn-primary" form="importTestingData">
					<i class="fas fa-upload"></i> Upload
				</button>
			</div>
		</div>
	</div>
</div>
{{-- <div class="alert alert-info" role="alert">
	<i class="fas fa-circle-info"></i>
	Mohon untuk tidak menginput atau mengupload data yang sama dengan data training
</div> --}}
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
					title="Jumlah Data Testing dengan nama duplikat">
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
						<a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalAddTesting">
							<i class="fas fa-pen"></i> Input Manual
						</a>
					</li>
					<li>
						<a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalImportTesting">
							<i class="fas fa-upload"></i> Upload File
						</a>
					</li>
				</ul>
			</div>
			<button type="button" class="btn btn-danger" id="delete-all" disabled>
				<i class="fas fa-trash"></i> Hapus Data
			</button>
			<a href="{{route('testing.export')}}" class="btn btn-success disabled" id="dlBtn">
				<i class="fas fa-download"></i> Ekspor
			</a>
		</div>
		<table class="table table-bordered" id="table-testing" style="width: 100%">
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
	let dt_testing = $("#table-testing"), errmsg;
	const modalForm = $("#modalAddTesting");
	$(document).ready(function () {
		try {
			$.fn.dataTable.ext.errMode = "none";
			dt_testing = dt_testing.DataTable({
				stateSave: true,
				lengthChange: false,
				serverSide: true,
				processing: true,
				responsive: true,
				searching: false,
				ajax: "{{ route('testing.create') }}",
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
					targets: 1 + {{$loop->index}},
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
							`<button class="btn btn-primary edit-record" data-id="${data}" data-bs-toggle="modal" data-bs-target="#modalAddTesting">` +
							'<i class="fas fa-pen-to-square"></i>' +
							'</button>' +
							`<button class="btn btn-danger delete-record" data-id="${data}" data-name="${full['nama']}">` +
							'<i class="fas fa-trash"></i>' +
							'</button>' +
							"</div>");
					}
				}],
				language: {
					url: "https://cdn.datatables.net/plug-ins/2.0.0/i18n/id.json"
				},
				drawCallback: function(){
					let total=this.api().page.info().recordsTotal;
					if(total===0){
						$('#dlBtn').addClass('disabled');
						$("#delete-all").prop('disabled',true);
					}	else {
						$('#dlBtn').removeClass('disabled');
						$("#delete-all").prop('disabled',false);
					}
					$("#total-counter").text(total);
					$.get("{{ route('testing.count') }}", function (data) {
						$('#total-duplicate').text(data.duplicate);
						$("#total-missing").text(data.empty);
					}).fail(function (xhr, st) {
						console.warn(xhr.responseJSON.message ?? st);
						Notiflix.Notify.failure(
							`Gagal memuat jumlah: Kesalahan HTTP ${xhr.status} ${xhr.statusText}`
						);
					});
				}
			}).on("dt-error", function (e, settings, techNote, message) {
				errorDT(message);
			});
		} catch (dterr) {
			initError(dterr.message);
		}
	}).on("click", "#delete-all", function () {
		Notiflix.Confirm.show(
			"Hapus semua Data Testing?",
			'Anda akan menghapus semua Data Testing yang akan mereset hasil klasifikasi terkait.',
			'Ya',
			'Tidak',
			function () {
				$.ajax({
					type: "DELETE",
					headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
					url: "{{route('testing.clear')}}",
					beforeSend: function(){
						Notiflix.Loading.standard('Menghapus');
					},complete:function(){
						Notiflix.Loading.remove();
					},
					success: function () {
						if ($.fn.DataTable.isDataTable("#table-testing")) dt_testing.draw();
						Notiflix.Notify.success("Semua data berhasil dihapus");
					},
					error: function (xhr, st) {
						console.warn(xhr.responseJSON.message ?? st);
						Notiflix.Notify.failure(
							`Gagal hapus: Kesalahan HTTP ${xhr.status} ${xhr.statusText}`
						);
					}
				});
			}
		);
	}).on("click", ".delete-record", function () {
		let test_id = $(this).data("id"), test_name = $(this).data("name");
		Notiflix.Confirm.show(
			"Hapus Data Testing?",
			`Anda akan menghapus Data Testing ${test_name}.`,
			'Ya',
			'Tidak',
			function () {
				$.ajax({
					type: "DELETE",
					headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
					url: 'testing/' + test_id,
					beforeSend: function () {
						Notiflix.Loading.standard('Menghapus');
					},
					complete: function () {
						Notiflix.Loading.remove();
					},
					success: function () {
						dt_testing.draw();
						Notiflix.Notify.success("Berhasil dihapus");
						return "Dihapus";
					},
					error: function (xhr, st) {
						if (xhr.status === 404) {
							dt_testing.draw();
							errmsg = `Data Testing ${test_name} tidak ditemukan`;
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
		let test_id = $(this).data("id");
		$("#modalAddTestingLabel").text("Edit Data Testing");
		Notiflix.Block.standard('.modal-content','Memuat');
		$.get(`testing/${test_id}/edit`, function (data) {
			$("#test_id").val(data.id);
			$("#testName").val(data.nama);
			$('#testResult').val(data.status);
			@foreach($atribut as $attr)
			$("#test-{{$attr->slug}}").val(data.{{$attr->slug}});
			@endforeach
		}).fail(function (xhr, st) {
			if (xhr.status === 404) {
				dt_testing.draw();
				modalForm.modal('hide');
				errmsg = "Data Testing tidak ditemukan";
			} else {
				console.warn(xhr.responseJSON.message ?? st);
				errmsg = `Kesalahan HTTP ${xhr.status} ${xhr.statusText}`;
			}
			Notiflix.Notify.failure("Gagal memuat data: "+errmsg);
		}).always(function () {
			Notiflix.Block.remove('.modal-content');
		});
	});
	$('#importTestingData').submit(function(e) {//form Upload Data
		e.preventDefault();
		$.ajax({
			type: "POST",
			url: "{{route('testing.import')}}",
			dataType: 'JSON',
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData: false,
			beforeSend: function () {
				Notiflix.Block.standard('.modal-content','Mengupload');
				resetvalidation();
			},
			complete: function () {
				Notiflix.Block.remove('.modal-content');
			},
			success: function (status) {
				if ($.fn.DataTable.isDataTable("#table-testing")) dt_testing.draw();
				$('#modalImportTesting').modal("hide");
				Notiflix.Notify.success("Berhasil diupload");
			},
			error: function (xhr, st) {
				$("#testData").addClass("is-invalid");
				$("#data-error").text(xhr.responseJSON.message);
				if (xhr.status === 422) errmsg = xhr.responseJSON.message;
				else {
					console.warn(xhr.responseJSON.message ?? st);
					errmsg = `Kesalahan HTTP ${xhr.status} ${xhr.statusText}`;
				}
				$('#modalImportTesting').modal("handleUpdate");
				Notiflix.Notify.failure("Gagal upload: " +errmsg);
			}
		});
	});
	$("#addNewTestingForm").submit(function (ev) {//form Input Manual
		ev.preventDefault();
		$.ajax({
			data: $("#addNewTestingForm").serialize(),
			url: "{{ route('testing.store') }}",
			type: "POST",
			beforeSend: function () {
				Notiflix.Block.standard('.modal-content','Menyimpan');
				resetvalidation();
			},
			complete: function () {
				Notiflix.Block.remove('.modal-content');
			},
			success: function (status) {
				if ($.fn.DataTable.isDataTable("#table-testing")) dt_testing.draw();
				modalForm.modal("hide");
				Notiflix.Notify.success(status.message);
			},
			error: function (xhr, st) {
				if (xhr.status === 422) {
					if (typeof xhr.responseJSON.errors.nama !== "undefined") {
						$("#testName").addClass("is-invalid");
						$("#name-error").text(xhr.responseJSON.errors.nama);
					}
					@foreach($atribut as $attr)
					if (typeof xhr.responseJSON.errors.{{$attr->slug}} !== "undefined") {
						$("#test-{{$attr->slug}}").addClass("is-invalid");
						$("#{{$attr->slug}}-error").text(xhr.responseJSON.errors.{{$attr->slug}});
					}
					@endforeach
					if (typeof xhr.responseJSON.errors.status !== "undefined") {
						$("#testResult").addClass("is-invalid");
						$("#result-error").text(xhr.responseJSON.errors.status);
					}
					errmsg = xhr.responseJSON.message;
					modalForm.modal("handleUpdate");
				} else if(xhr.status === 400) {
					$("#testResult").addClass("is-invalid");
					$("#result-error").text("Probabilitas belum dihitung");
					errmsg=xhr.responseJSON.message;
				}	else {
					console.warn(xhr.responseJSON.message ?? st);
					errmsg = `Gagal: Kesalahan HTTP ${xhr.status} ${xhr.statusText}`;
				}
				Notiflix.Notify.failure(errmsg);
			}
		});
	});
	modalForm.on("hidden.bs.modal", function () {
		resetvalidation();
		$("#modalAddTestingLabel").text("Tambah Data Testing");
		$("#addNewTestingForm")[0].reset();
	});
	$('#modalImportTesting').on('hidden.bs.modal',function(){
		resetvalidation();
		$("#importTestingData")[0].reset();
	});
</script>
@endsection