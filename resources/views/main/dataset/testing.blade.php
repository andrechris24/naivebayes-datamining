@extends('layout')
@section('title', 'Data Testing')
@section('content')
<div class="modal fade" tabindex="-1" id="modalAddTesting" aria-labelledby="modalAddTestingLabel" role="dialog"
	aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 id="modalAddTestingLabel" class="modal-title">
					Tambah Data Testing
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form class="needs-validation" id="addNewTestingForm">@csrf
					<input type="hidden" name="id" id="test_id">
					<div class="form-floating mb-4">
						<input type="text" class="form-control" id="testName" name="nama" placeholder="Nama" required />
						<label for="testName">Nama</label>
						<div class="invalid-tooltip" id="name-error">Masukkan Nama</div>
					</div>
					@foreach ($atribut as $attr)
					<div class="form-floating mb-4" data-bs-toggle="tooltip" title="{{$attr->desc}}">
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
						<div class="invalid-tooltip" id="{{$attr->slug}}-error">
							{{($attr->type==='numeric'?'Masukkan ':'Pilih ').$attr->name}}
						</div>
					</div>
					@endforeach
					<div class="form-floating mb-4">
						<select name="status" class="form-select" id="testResult" required>
							<option value="">Pilih</option>
							<option value="1">{{$hasil[true]}}</option>
							<option value="0">{{$hasil[false]}}</option>
							<option value="Otomatis" @if($calculated===0) disabled @endif>
								Pilih otomatis
							</option>
						</select>
						<label for="testResult">Hasil</label>
						<div class="invalid-tooltip" id="result-error">Pilih hasil</div>
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
				<button type="button" class="btn btn-success" data-bs-toggle="modal"
					data-bs-target="#modalImportTesting">
					<i class="fas fa-upload"></i> Upload File
				</button>
				<button type="submit" class="btn btn-primary data-submit" form="addNewTestingForm">
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
					<a href="{{route('template-data')}}" class="alert-link">Klik disini</a> untuk mendownload template Dataset
				</div>
				<form id="importTestingData">@csrf
					<input type="file" class="form-control" id="testData" name="data" aria-describedby="importFormats"
						data-bs-toggle="tooltip" title="Format: xls, xlsx, csv, dan tsv"
						accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.oasis.opendocument.spreadsheet,text/csv,.tsv"
						required>
					<div class="invalid-tooltip" id="data-error"></div>
				</form>
			</div>
			<div class="modal-footer">
				<div class="spinner-grow text-success me-3 d-none" role="status">
					<span class="visually-hidden">Mengupload..</span>
				</div>
				<button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">
					<i class="fas fa-x"></i> Batal
				</button>
				<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAddTesting">
					<i class="fas fa-pen"></i> Input Manual
				</button>
				<button type="submit" class="btn btn-primary data-submit" form="importTestingData">
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
		<div class="btn-group mb-2" role="group">
			<div class="btn-group" role="group">
				<button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
					aria-expanded="false">
					<i class="fas fa-plus"></i> Tambah Data <i class="fa-solid fa-caret-down"></i>
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
			<button type="button" class="btn btn-danger delete-all">
				<i class="fas fa-trash"></i> Hapus Data
			</button>
			<a href="{{route('testing.export')}}" class="btn btn-success">
				<i class="fas fa-download"></i> Ekspor Data
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
				}
			}).on("dt-error", function (e, settings, techNote, message) {
				errorDT(message, techNote);
			}).on('preXhr', function () {
				$.get("{{ route('testing.count') }}", function (data) {
					if(data.total===0) $('.download-data').prop('disabled',true);
					else $('.download-data').prop('disabled',false);
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
	}).on("click", ".delete-all", function () {
		confirm.fire({
			titleText: "Hapus semua Data Testing?",
			text: 'Anda akan menghapus semua Data Testing yang akan mereset hasil klasifikasi terkait.',
			preConfirm: async () => {
				try {
					await $.ajax({
						type: "DELETE",
						headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
						url: "{{route('testing.clear')}}",
						success: function () {
							if ($.fn.DataTable.isDataTable("#table-testing")) dt_testing.draw();
							return "Dihapus";
						},
						error: function (xhr, st) {
							console.warn(xhr.responseJSON.message ?? st);
							return Swal.showValidationMessage(
								`Gagal hapus: Kesalahan HTTP ${xhr.status} ${xhr.statusText}`);
						}
					});
				} catch (error) {
					console.error(error.responseJSON);
				}
			}
		}).then(function (result) {
			if (result.isConfirmed) 
				notif.open({ type: "success", message:"Semua data berhasil dihapus" });
		});
	}).on("click", ".delete-record", function () {
		let test_id = $(this).data("id"), test_name = $(this).data("name");
		confirm.fire({
			titleText: "Hapus Data Testing?",
			text: `Anda akan menghapus Data Testing ${test_name}.`,
			preConfirm: async () => {
				try {
					await $.ajax({
						type: "DELETE",
						headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
						url: 'testing/' + test_id,
						success: function () {
							dt_testing.draw();
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
		let test_id = $(this).data("id");
		$("#modalAddTestingLabel").html("Edit Data Testing");
		$('.btn-success').prop('disabled',true);
		formloading("#addNewTestingForm :input", true);
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
			notif.open({ type: "error", message: "Gagal memuat data: "+errmsg });
		}).always(function () {
			formloading("#addNewTestingForm :input", false);
			$('.btn-success').prop('disabled',false);
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
				formloading("#importTestingData :input", true);
				$('#modalImportTesting :button').prop('disabled',true);
				$("#importTestingData :input").removeClass("is-invalid");
			},
			complete: function () {
				$('#modalImportTesting :button').prop('disabled',false);
				formloading("#importTestingData :input", false);
			},
			success: function (status) {
				if ($.fn.DataTable.isDataTable("#table-testing")) dt_testing.draw();
				$('#modalImportTesting').modal("hide");
				notif.open({ type: "success", message:"Berhasil diupload" });
			},
			error: function (xhr, st) {
				if (xhr.status === 422) {
					resetvalidation();
					if (typeof xhr.responseJSON.errors.data !== "undefined") {
						$("#testData").addClass("is-invalid");
						$("#data-error").text(xhr.responseJSON.errors.data);
					}
					errmsg = xhr.responseJSON.message;
				} else {
					console.warn(xhr.responseJSON.message ?? st);
					errmsg = `Kesalahan HTTP ${xhr.status}. ${xhr.statusText}`;
				}
				notif.open({ type: "error", message: "Gagal upload: " +errmsg});
			}
		});
	});
	function submitform(ev) {//form Input Manual
		ev.preventDefault();
		$.ajax({
			data: $("#addNewTestingForm").serialize(),
			url: "{{ route('testing.store') }}",
			type: "POST",
			beforeSend: function () {
				$("#addNewTestingForm :input").removeClass("is-invalid");
				$('#modalAddTesting :button').prop('disabled',true);
				formloading("#addNewTestingForm :input", true);
			},
			complete: function () {
				$('#modalAddTesting :button').prop('disabled',false);
				formloading("#addNewTestingForm :input", false);
			},
			success: function (status) {
				if ($.fn.DataTable.isDataTable("#table-testing")) dt_testing.draw();
				modalForm.modal("hide");
				notif.open({ type: "success", message: status.message });
			},
			error: function (xhr, st) {
				if (xhr.status === 422) {
					resetvalidation();
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
		$("#modalAddTestingLabel").html("Tambah Data Testing");
		$("#addNewTestingForm")[0].reset();
		$("#test_id").val("");
		$("#name-error").text("Masukkan Nama");
		@foreach($atribut as $attr)
			@if($attr->type==='numeric')
			$("#{{$attr->slug}}-error").text("Masukkan {{$attr->slug}}");
			@else
			$("#{{$attr->slug}}-error").text("Pilih {{$attr->slug}}");
			@endif
		@endforeach
		$("#result-error").text("Pilih hasil");
	});
</script>
@endsection