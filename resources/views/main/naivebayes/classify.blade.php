@extends('layout')
@section('title','Hasil Klasifikasi')
@section('content')
<div class="modal fade" tabindex="-1" id="modalCalcClass" aria-labelledby="modalCalcClassLabel" role="dialog"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 id="modalCalcClassLabel" class="modal-title">
					Hitung Klasifikasi
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<p>Pilih tipe data yang akan dihitung hasil klasifikasinya.</p>
				<form id="formCalcClass">@csrf
					<div class="position-relative">
						<select class="form-select" name="tipe" id="calc-select" required>
							<option value="train">Data Training (Data Latih)</option>
							<option value="test" selected>Data Testing (Data Uji)</option>
						</select>
						<div class="invalid-tooltip" id="calc-error"></div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
					<i class="fas fa-x"></i> Batal
				</button>
				<button type="submit" class="btn btn-primary" form="formCalcClass">
					<i class="fas fa-calculator"></i> Hitung
				</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" tabindex="-1" id="modalResetClass" aria-labelledby="modalResetClassLabel" role="dialog"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header bg-danger">
				<h5 id="modalResetClassLabel" class="modal-title text-white">
					Reset Klasifikasi?
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<p>Anda akan mereset hasil klasifikasi.
					Pilih tipe data yang akan direset hasil klasifikasinya.</p>
				<form id="formResetClass">@csrf
					<div class="position-relative">
						<select class="form-select" name="tipe" id="reset-select" required>
							<option value="" selected>Pilih</option>
							<option value="train">Data Training (Data Latih)</option>
							<option value="test">Data Testing (Data Uji)</option>
							<option value="all">Semua</option>
						</select>
						<div class="invalid-tooltip" id="reset-error"></div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
					<i class="fas fa-x"></i> Batal
				</button>
				<button type="submit" class="btn btn-danger" form="formResetClass">
					<i class="fas fa-check"></i> Reset
				</button>
			</div>
		</div>
	</div>
</div>
<div class="card">
	<div class="card-body">
		<div class="btn-group mb-2" role="button">
			<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCalcClass">
				<i class="fas fa-calculator"></i> Hitung
			</button>
			<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalResetClass">
				<i class="fa-solid fa-arrow-rotate-right"></i> Reset
			</button>
			<button class="btn btn-success dropdown-toggle" id="expBtn" type="button" data-bs-toggle="dropdown"
				aria-expanded="false" disabled>
				<i class="fas fa-download"></i> Ekspor <i class="fa-solid fa-caret-down"></i>
			</button>
			<ul class="dropdown-menu">
				<li>
					<a class="dropdown-item" href="{{route('class.export','test')}}">
						Data Testing
					</a>
				</li>
				<li>
					<a class="dropdown-item" href="{{route('class.export','train')}}">
						Data Training
					</a>
				</li>
				<li>
					<a class="dropdown-item" href="{{route('class.export','all')}}">
						Semua Data
					</a>
				</li>
			</ul>
		</div>
		<table class="table table-bordered" id="table-classify" width="100%">
			<thead>
				<tr>
					<th>#</th>
					<th>Nama</th>
					<th>Tipe Data</th>
					<th>{{$hasil[true]}}</th>
					<th>{{$hasil[false]}}</th>
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
					{ data: "true" },
					{ data: "false" },
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
				drawCallback: function(){
					if(this.api().page.info().recordsTotal===0)
						$('#expBtn').prop('disabled',true);
					else $('#expBtn').prop('disabled',false);
				}
			}).on("dt-error", function (e, settings, techNote, message) {
				errorDT(message, techNote);
			});
		} catch (dterr) {
			initError(dterr.message);
		}
	});
	$("#formResetClass").submit(function(e){
		e.preventDefault();
		$.ajax({
			type: "DELETE",
			data: $("#formResetClass").serialize(),
			dataType: 'JSON',
			url: "{{route('class.reset')}}",
			beforeSend: function(){
				Notiflix.Loading.standard('Mereset');
				$('#reset-select').removeClass('is-invalid');
			},
			complete: function(){
				Notiflix.Loading.remove();
			},
			success: function () {
				if ($.fn.DataTable.isDataTable("#table-classify")) dt_classify.draw();
				$("#modalResetClass").modal('hide');
				Notiflix.Notify.success("Berhasil direset");
			},
			error: function (xhr, st) {
				if (xhr.status === 422 || xhr.status === 400){
					errmsg = xhr.responseJSON.message;
					$('#reset-select').addClass('is-invalid');
					$("#reset-error").text(xhr.responseJSON.message);
				} else {
					console.warn(xhr.responseJSON.message ?? st);
					errmsg = `Kesalahan HTTP ${xhr.status}. ${xhr.statusText}`;
				}
				Notiflix.Notify.failure('Gagal reset: ' + errmsg);
			}
		});
	});
	$("#formCalcClass").submit(function(e){
		e.preventDefault();
		$.ajax({
			url: "{{ route('class.create') }}",
			type: "POST",
			data: $("#formCalcClass").serialize(),
			dataType: 'JSON',
			beforeSend: function(){
				$("#calc-select").removeClass('is-invalid');
				Notiflix.Loading.standard('Menghitung');
			},
			complete: function(){
				Notiflix.Loading.remove();
			},
			success: function () {
				if ($.fn.DataTable.isDataTable("#table-classify")) dt_classify.draw();
				$("#modalCalcClass").modal('hide');
				Notiflix.Notify.success("Berhasil dihitung");
			},
			error: function (xhr, st) {
				if (xhr.status === 422 || xhr.status === 400){
					errmsg = xhr.responseJSON.message;
					$('#calc-select').addClass('is-invalid');
					$("#calc-error").text(xhr.responseJSON.message);
				} else {
					console.warn(xhr.responseJSON.message ?? st);
					errmsg = `Gagal hitung: Kesalahan HTTP ${xhr.status}. ${xhr.statusText}`;
				}
				Notiflix.Notify.failure(errmsg);
			}
		});
	});
</script>
@endsection