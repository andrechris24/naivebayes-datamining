@extends('layout2')
@section('title','Particle Swarm Optimization')
@section('content')
<div class="modal fade" tabindex="-1" id="modalPSO" aria-labelledby="modalPSOLabel" role="dialog"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 id="modalPSOLabel">Input data</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form class="needs-validation" id="PSOForm">@csrf
					<div class="form-floating mb-3">
						<select name="atribut" id="data-select" class="form-control" required>
							<option value="" selected>Pilih</option>
							@foreach($atribut as $attr)
							<option value="{{$attr->slug}}">{{$attr->name}}</option>
							@endforeach
						</select>
						<label for="data-select">Pilih Atribut</label>
						<div class="invalid-feedback" id="data-error">
							Pilih Atribut yang akan dihitung
						</div>
					</div>
					<div class="form-floating mb-3">
						<input type="number" name="loop" class="form-control" min="1" max="20" id="iterasi"
							placeholder="Maksimal 20" required>
						<label for="iterasi">Jumlah iterasi (Perulangan)</label>
						<div class="invalid-feedback" id="loop-error">
							Masukkan jumlah (1-20)
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
				<button type="submit" class="btn btn-primary data-submit" form="PSOForm">
					<i class="bi bi-save"></i> Simpan
				</button>
			</div>
		</div>
	</div>
</div>
<div class="btn-group" role="button" id="spare-button">
	<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPSO">
		<i class="mdi mdi-calculator"></i> Input
	</button>
	<button type="button" class="btn btn-danger clear-data">
		<i class="mdi mdi-reload"></i> Reset
	</button>
</div>
<div class="card my-3">
	<div class="card-body">
		<table class="table table-bordered" id="table-pso" width="100%">
			<thead>
				<tr>
					<th>No</th>
					<th>Atribut</th>
					<th>Data</th>
					<th>Velocity</th>
					<th>Fungsi</th>
					<th>PBest</th>
					<th>GBest</th>
				</tr>
			</thead>
		</table>
	</div>
</div>
@endsection
@section('js')
<script type="text/javascript">
	let dt_pso = $("#table-pso");
	const modalForm = $("#modalPSO");
	$(document).ready(function(){
		try {
			$.fn.dataTable.ext.errMode = "none";
			dt_pso = dt_pso.DataTable({
				stateSave: true,
				lengthChange: false,
				serverSide: true,
				processing: true,
				responsive: true,
				searching: false,
				ajax: "{{ route('pso.datatable') }}",
				columns: [
					{ data: "loop" },
					{ data: "atribut" },
					{ data: "data" },
					{ data: "velocity" },
					{ data: "function" },
					{ data: "pbest" },
					{ data :"gbest" }
				],
				language: {
					url: "https://cdn.datatables.net/plug-ins/2.0.0/i18n/id.json"
				},
				layout: {
					topStart: {
						buttons: [{
							text: '<i class="mdi mdi-calculator"></i> Input',
							attr: {
								"data-bs-toggle": "modal",
								"data-bs-target": "#modalPSO"
							}
						}, {
							text: '<i class="mdi mdi-reload"></i> Reset',
							className: 'clear-data'
						}]
					}
				}
			}).on("dt-error", function (e, settings, techNote, message) {
				errorDT(message, techNote);
			}).on('preInit', removeBtn());
		} catch (dterr) {
			initError(dterr.message);
		}
	}).on("click", ".clear-data", function () {
		confirm.fire({
			titleText: "Reset Data?",
			text: 'Anda akan mereset hasil perhitungan Particle Swarm Optimization. Pilih atribut yang akan direset hasil perhitungannya.',
			input: "select",
			inputOptions: {
				@foreach($atribut as $attr)
				{{$attr->slug}}: "{{$attr->name}}",
				@endforeach
				all: "Semua Atribut"
			},
			inputPlaceholder: "Pilih Atribut",
			inputValidator: (value) => {
				if (!value) return "Anda harus memilih atribut";
			},
			preConfirm: async (attr) => {
				try {
					await $.ajax({
						type: "DELETE",
						data: {
							atribut: attr
						},
						headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
						dataType: 'JSON',
						url: "{{route('pso.reset')}}",
						success: function () {
							if ($.fn.DataTable.isDataTable("#table-pso")) dt_pso.draw();
							return "Direset";
						},
						error: function (xhr, st) {
							console.warn(xhr.responseJSON.message ?? st);
							return Swal.showValidationMessage(`Gagal reset: Kesalahan HTTP ${xhr.status}. ${xhr.statusText}`);
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
					titleText: "Berhasil direset"
				});
			}
		});
	});
	function submitform(e){
		e.preventDefault();
		$.ajax({
			data: $("#PSOForm").serialize(),
			url: "{{ route('pso.store') }}",
			type: "POST",
			beforeSend: function () {
				formloading("#PSOForm :input", true);
				$("#PSOForm :input").removeClass("is-invalid");
			},
			complete: function () {
				formloading("#PSOForm :input", false);
			},
			success: function (status) {
				if ($.fn.DataTable.isDataTable("#table-pso")) dt_pso.draw();
				modalForm.modal("hide");
				swal.fire({
					icon: "success",
					titleText: status.message
				});
			},
			error: function (xhr, st) {
				if (xhr.status === 422) {
					resetvalidation();
					if (typeof xhr.responseJSON.errors.atribut !== "undefined") {
						$("#data-select").addClass("is-invalid");
						$("#data-error").text(xhr.responseJSON.errors.atribut);
					}
					if (typeof xhr.responseJSON.errors.loop !== "undefined") {
						$("#iterasi").addClass("is-invalid");
						$("#loop-error").text(xhr.responseJSON.errors.loop);
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
	}
	modalForm.on("hidden.bs.modal", function () {
		resetvalidation();
		$("#PSOForm")[0].reset();
	});
</script>
@endsection