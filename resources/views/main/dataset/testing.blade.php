@extends('layout')
@section('title', 'Data Testing')
@section('content')
<div class="modal fade" tabindex="-1" id="modalAddTesting" aria-labelledby="modalAddTestingLabel" role="dialog"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 id="modalAddTestingLabel" class="modal-title">Tambah Data Testing</h5>
				<button type="button" class="btn-close text-reset" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form class="add-new-category needs-validation" id="addNewTestingForm">
					@csrf
					<input type="hidden" name="id" id="test_id">
					<div class="form-floating mb-3">
						<input type="text" class="form-control" id="testName" name="nama" placeholder="Nama" required />
						<label for="testName">Nama</label>
						<div class="invalid-feedback" id="name-error">
							Masukkan Nama
						</div>
					</div>
					@foreach ($atribut as $attr)
					<div class="form-floating mb-3" data-bs-toggle="tooltip" title="{{$attr->desc}}">
						@if ($attr->type==='numeric')
						@php($msg="Isikan ")
						<input type="number" class="form-control" min="0" name="q[{{$attr->slug}}]"
							id="test-{{$attr->slug}}" placeholder="123456789">
						@else
						@php($msg="Pilih ")
						<select name="q[{{$attr->slug}}]" class="form-select" id="test-{{$attr->slug}}">
							<option value="">Pilih</option>
							@foreach ($nilai->where('atribut_id',$attr->id) as $sub)
							<option value="{{$sub->id}}">{{$sub->name}}</option>
							@endforeach
						</select>
						@endif
						<label for="test-{{$attr->slug}}">{{$attr->name}}</label>
						<div class="invalid-feedback" id="{{$attr->slug}}-error">
							{{$msg.$attr->name}}
						</div>
					</div>
					@endforeach
				</form>
			</div>
			<div class="modal-footer">
				<div class="spinner-grow text-primary me-3 d-none" role="status">
					<span class="visually-hidden">Menyimpan...</span>
				</div>
				<button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">
					<i class="bi bi-x-lg"></i> Batal
				</button>
				<button type="submit" class="btn btn-primary data-submit" form="addNewTestingForm">
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
			<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddTesting">
				<i class="bi bi-plus-lg"></i> Tambah Data Testing
			</button>
			<button type="button" class="btn btn-danger delete-all">
				<i class="bi bi-trash3-fill"></i> Hapus semua data
			</button>
		</div>
		<table class="table table-bordered" id="table-testing" width="100%">
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
					render: function (data, type, full, meta) {
						return meta.settings._iDisplayStart + meta.row + 1;
					}
				},
				@foreach ($atribut as $attr)
				{
					targets: 1+{{$loop->index}},
					render:function(data){
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
							`<button class="btn btn-primary edit-record" data-id="${data}" data-bs-toggle="modal" data-bs-target="#modalAddTesting">` +
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
							text: '<i class="bi bi-plus-lg"></i> Tambah Data Testing',
							className: "add-new",
							attr: {
								"data-bs-toggle": "modal",
								"data-bs-target": "#modalAddTesting"
							}
						}, {
							text: '<i class="bi bi-trash3-fill"></i> Hapus semua data',
							className: "delete-all"
						}, {
							extend: "collection",
							text: '<i class="bi bi-download"></i> Ekspor Data',
							buttons: [{
								extend: "excel",
								title: "Data Testing",
								text: '<i class="bi bi-file-earmark-spreadsheet"></i> Excel',
								exportOptions: {
							    columns: ':not(:last-child)',
							  }
							}, {
								extend: "pdf",
								title: "Data Testing",
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
				$.get("{{ route('testing.count') }}", function (data) {
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
			title: "Hapus semua Data Testing?",
			text: 'Anda akan menghapus semua Data Testing yang akan mempengaruhi klasifikasi terkait.',
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
		let test_id = $(this).data("id"), test_name = $(this).data("name");
		confirm.fire({
			title: "Hapus Data Testing?",
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
		let test_id = $(this).data("id");
		$("#modalAddTestingLabel").html("Edit Data Testing");
		formloading("#addNewTestingForm :input",true);
		$.get(`testing/${test_id}/edit`, function (data) {
			$("#test_id").val(data.id);
			$("#testName").val(data.nama);
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
				errmsg = `Kesalahan HTTP ${xhr.status}. ${xhr.statusText}`;
			}
			swal.fire({
				icon: "error",
				title: "Gagal memuat data",
				text: errmsg
			});
		}).always(function () {
			formloading("#addNewTestingForm :input",false);
		});
	});
	function submitform(ev) {
		ev.preventDefault();
		$.ajax({
			data: $("#addNewTestingForm").serialize(),
			url: "{{ route('testing.store') }}",
			type: "POST",
			beforeSend: function () {
				formloading("#addNewTestingForm :input",true);
				$("#addNewTestingForm :input").removeClass("is-invalid");
			},
			complete: function () {
				formloading("#addNewTestingForm :input",false);
			},
			success: function (status) {
				if ($.fn.DataTable.isDataTable("#table-testing")) dt_testing.draw();
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
						$("#testName").addClass("is-invalid");
						$("#name-error").text(xhr.responseJSON.errors.namaa);
					}
					@foreach($atribut as $attr)
					if (typeof xhr.responseJSON.errors.{{$attr->slug}} !== "undefined") {
						$("#test-{{$attr->slug}}").addClass("is-invalid");
						$("#{{$attr->slug}}-error").text(xhr.responseJSON.errors.{{$attr->slug}});
					}
					@endforeach
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
		$("#modalAddTestingLabel").html("Tambah Data Testing");
		$("#addNewTestingForm")[0].reset();
		$("#test_id").val("");
	});
</script>
@endsection