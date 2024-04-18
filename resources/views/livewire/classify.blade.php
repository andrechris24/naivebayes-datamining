@section('title','Hasil Klasifikasi')
@section('content')
<div class="card">
	<div class="card-body">
		<div class="modal fade" tabindex="-1" id="modalCalcClass" aria-labelledby="modalCalcClassLabel"
			role="dialog" aria-hidden="true" wire:ignore.self>
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
						<form wire:submit.prevent="calc" id="formCalcClass">
							<select class="form-select @error('type') is-invalid @enderror " wire:model="type" required>
								<option value="train">Data Training (Data Latih)</option>
								<option value="test">Data Testing (Data Uji)</option>
							</select>
							@error('type')
							<div class="invalid-feedback">{{$message}}</div>
							@enderror
						</form>
					</div>
					<div class="modal-footer">
						<div wire:loading wire:target="calc">Menghitung...</div>
						<button type="button" class="btn btn-tertiary" data-bs-dismiss="modal">
							<i class="fas fa-x"></i> Tidak
						</button>
						<button type="submit" class="btn btn-primary" form="formCalcClass">
							<i class="fas fa-check"></i> Hitung
						</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" tabindex="-1" id="modalResetClass" aria-labelledby="modalResetClassLabel"
			role="dialog" aria-hidden="true" wire:ignore.self>
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
						<form wire:submit.prevent="resetCalc" id="formResetClass">
							<select class="form-select @error('type') is-invalid @enderror " wire:model="type" required>
								<option value="" selected>Pilih tipe data</option>
								<option value="train">Data Training (Data Latih)</option>
								<option value="test">Data Testing (Data Uji)</option>
								<option value="all">Semua</option>
							</select>
							@error('type')
							<div class="invalid-feedback">{{$message}}</div>
							@enderror
						</form>
					</div>
					<div class="modal-footer">
						<div wire:loading wire:target="resetCalc">Mereset...</div>
						<button type="button" class="btn btn-tertiary" data-bs-dismiss="modal">
							<i class="fas fa-x"></i> Batal
						</button>
						<button type="submit" class="btn btn-danger" form="formResetClass">
							<i class="fas fa-check"></i> Reset
						</button>
					</div>
				</div>
			</div>
		</div>
		<div class="btn-group mb-2" role="button">
			<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCalcClass">
				<i class="fas fa-calculator"></i> Hitung
			</button>
			<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalResetClass">
				<i class="fa-solid fa-arrow-rotate-right"></i> Reset
			</button>
			<button class="btn btn-success dropdown-toggle download-data" type="button" data-bs-toggle="dropdown"
				aria-expanded="false">
				<i class="fas fa-download"></i> Ekspor <i class="fa-solid fa-caret-down"></i>
			</button>
			<ul class="dropdown-menu">
				<li>
					<a class="dropdown-item" wire:click.prevent="ekspor('test')">
						Data Testing
					</a>
				</li>
				<li>
					<a class="dropdown-item" wire:click.prevent="ekspor('train')">
						Data Training
					</a>
				</li>
				<li>
					<a class="dropdown-item" wire:click.prevent="ekspor('all')">
						Semua Data
					</a>
				</li>
			</ul>
		</div>
		<div class="table-responsive" wire:ignore>
			<table class="table table-bordered" id="table-classify" width="100%" wire:ignore>
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
</div>
@push('js')
<script type="text/javascript">
	@once
	let dt_classify = $("#table-classify");
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
				ajax: "{{ route('class.dt') }}",
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
						$('.download-data').prop('disabled',true);
					else $('.download-data').prop('disabled',false);
				}
			}).on("dt-error", function (e, settings, techNote, message) {
				errorDT(message, techNote);
			});
		} catch (dterr) {
			initError(dterr.message);
		}
	});
	@endonce
	Livewire.on('toast', (r) => {
		if (r.type==='success'){
			$('.modal').modal('hide');
			if($.fn.DataTable.isDataTable("#table-classify")) dt_classify.draw();
		}
		notif.open({ type: r.type, message: r.msg });
	});
</script>
@endpush