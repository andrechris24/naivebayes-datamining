@extends('layout')
@section('title','Hasil Klasifikasi')
@section('content')
<div class="card">
	<div class="card-body">
		<div class="btn-group mb-3" role="button" id="spare-button">
			<button type="button" class="btn btn-primary calc-class">
				<i class="bi bi-calculator"></i> Hitung
			</button>
			<button type="button" class="btn btn-danger reset-class">
				<i class="bi bi-arrow-clockwise"></i> Reset
			</button>
		</div>
		<table class="table table-bordered" id="table-classify" width="100%">
			<thead>
				<tr>
					<th>#</th>
					<th>Nama</th>
					<th>Tipe Data</th>
					<th>Layak</th>
					<th>Tidak Layak</th>
					<th>Kelas Prediksi</th>
					<th>Kelas Asli</th>
				</tr>
			</thead>
		</table>
	</div>
</div>
@endsection
@section('js')
<script type="text/javascript">
	let dt_classify = $("#table-classify"), errmsg;
	$(document).ready(function () {
		try {
			$.fn.dataTable.ext.errMode = "none";
			dt_classify = dt_classify.DataTable({
				stateSave: true,
				lengthChange: false,
				serverSide: true,
				processing: true,
				responsive: true,
				searching: false,
				ajax: "{{ route('class.datatable') }}",
				columns: [
					{ data: "id" },
					{ data: "name" },
					{ data: "type" },
					{ data: "layak" },
					{ data: "tidak_layak" },
					{ data: "predicted" },
					{ data: "real" }
				],
				columnDefs: [{
					targets: 0,
					render: function (data, type, full, meta) {
						return meta.settings._iDisplayStart + meta.row + 1;
					}
				}],
				language: {
					url: "https://cdn.datatables.net/plug-ins/2.0.0/i18n/id.json"
				},
				layout: {
					topStart: {
						buttons: [{
							text: '<i class="bi bi-calculator"></i> Hitung',
							className: 'calc-class'
						}, {
							text: '<i class="bi bi-arrow-clockwise"></i> Reset',
							className: 'reset-class'
						}]
					}
				}
			}).on("dt-error", function (e, settings, techNote, message) {
				errorDT(message, techNote);
			}).on('preInit.dt', removeBtn());
		} catch (dterr) {
			initError(dterr.message);
		}
	}).on("click", ".reset-class", function () {
		confirm.fire({
			titleText: "Reset Klasifikasi?",
			text: 'Anda akan mereset hasil klasifikasi. Pilih tipe data yang akan direset hasilnya.',
			input: "select",
			inputOptions: {
				train: "Data Training (Data Latih)",
				test: "Data Testing (Data Uji)",
				all: "Semua Data"
			},
			inputPlaceholder: "Pilih Tipe Data",
			inputValidator: (value) => {
				if (!value) return "Anda harus memilih tipe data";
			},
			preConfirm: async (tipe) => {
				try {
					await $.ajax({
						type: "DELETE",
						headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
						data: {
							type: tipe
						},
						dataType: 'JSON',
						url: "{{route('class.reset')}}",
						success: function () {
							if ($.fn.DataTable.isDataTable("#table-classify"))
								dt_classify.draw();
							return "Dihapus";
						},
						error: function (xhr, st) {
							if (xhr.status === 422 || xhr.status === 400)
								errmsg = xhr.responseJSON.message;
							else {
								console.warn(xhr.responseJSON.message ?? st);
								errmsg = `Kesalahan HTTP ${xhr.status}. ${xhr.statusText}`;
							}
							return Swal.showValidationMessage('Gagal reset: ' + errmsg);
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
					titleText: "Berhasil direset"
				});
			}
		});
	}).on('click', '.calc-class', function(){
		Swal.fire({
			titleText: "Pilih tipe data yang akan dihitung",
			input: "select",
			inputOptions: {
				test: "Data Testing (Data Uji)",
				train: "Data Training (Data Latih)"
			},
			inputPlaceholder: "Pilih Tipe Data",
			showCancelButton: true,
			confirmButtonText: `<i class="bi bi-calculator"></i> Hitung`,
			cancelButtonText: `<i class="bi bi-x-lg"></i> Batal`,
			showLoaderOnConfirm: true,
			allowOutsideClick: () => !Swal.isLoading(),
			inputValidator: (value) => {
				if (!value) return "Anda harus memilih tipe data";
			},
			preConfirm: async (tipe) => {
				try {
					await $.ajax({
						url: "{{ route('class.create') }}",
						type: "POST",
						data: {
							type: tipe
						},
						dataType: 'JSON',
						headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
						success: function () {
							return "Berhasil dihitung";
						},
						error: function (xhr, st) {
							if (xhr.status === 422 || xhr.status === 400)
								errmsg = xhr.responseJSON.message;
							else {
								console.warn(xhr.responseJSON.message ?? st);
								errmsg = `Gagal hitung: Kesalahan HTTP ${xhr.status}. ${xhr.statusText}`;
							}
							return Swal.showValidationMessage(errmsg);
						}
					});
				} catch (error) {
					console.error(error.responseJSON);
				}
			}
		}).then((result) => {
			if (result.isConfirmed) {
				if ($.fn.DataTable.isDataTable("#table-classify")) dt_classify.draw();
				swal.fire({
					titleText: "Berhasil dihitung",
					icon: "success"
				});
			}
		});
	});
</script>
@endsection