@section('title','Atribut')
<div>
<div class="row" wire:ignore>
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
				<div class="d-flex align-items-start justify-content-between" data-bs-toggle="tooltip"
					title="Atribut Kategorikal yang tidak digunakan">
					<div class="content-left">
						<span>Tidak digunakan</span>
						<div class="d-flex align-items-end mt-2">
							<h3 class="mb-0 me-2"><span id="total-unused">-</span></h3>
						</div>
					</div>
					<span class="badge bg-danger rounded p-2">
						<i class="fas fa-circle-exclamation"></i>
					</span>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="card">
	<div class="card-body">
		<div wire:ignore.self class="modal fade" tabindex="-1" id="modalAddAtribut" aria-labelledby="modalAddAtributLabel" role="dialog"
			aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
			<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
				<div class="modal-content">
					<div class="modal-header" wire:ignore>
						<h5 id="modalAddAtributLabel" class="modal-title">Tambah Atribut</h5>
						<button type="button" class="btn-close text-reset" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<form id="addNewAtributForm" wire:submit="store">
							<input type="hidden" name="id" id="attr_id">
							<div class="form-floating mb-4">
								<input type="text" class="form-control @error('name') is-invalid @enderror " id="attrName" name="name" placeholder="Nama" required />
								<label for="attrName">Nama</label>
								@error('name')
								<div class="invalid-feedback">{{$message}}</div>
								@enderror
							</div>
							<div class="form-floating mb-4">
								<select wire:model="type" class="form-select @error('type') is-invalid @enderror " id="attrType" required>
									<option value="">Pilih</option>
									<option value="numeric">Numerik</option>
									<option value="categorical">Kategorikal</option>
								</select>
								<label for="attrType">Tipe Atribut</label>
								@error('type')
								<div class="invalid-feedback">{{$message}}</div>
								@enderror
							</div>
							<div class="form-floating mb-4">
								<input type="text" class="form-control @error('desc') is-invalid @enderror " id="attrDesc" wire:model="desc" placeholder="Keterangan" />
								<label for="attrDesc">Keterangan</label>
								@error('desc')
								<div class="invalid-feedback">{{$message}}</div>
								@enderror
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<div wire:loading wire:target="store" class="spinner-grow text-primary me-3 d-none" role="status">
							<span class="visually-hidden">Menyimpan...</span>
						</div>
						<button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">
							<i class="fas fa-x"></i> Batal
						</button>
						<button type="submit" class="btn btn-primary data-submit" form="addNewAtributForm">
							<i class="fas fa-floppy-disk"></i> Simpan
						</button>
					</div>
				</div>
			</div>
		</div>
		<button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#modalAddAtribut">
			<i class="fas fa-plus"></i> Tambah Atribut
		</button>
		<table class="table table-bordered" id="table-atribut" width="100%" wire:ignore>
			<thead>
				<tr>
					<th>#</th>
					<th>Nama</th>
					<th>Tipe Atribut</th>
					<th>Keterangan</th>
					<th>Aksi</th>
				</tr>
			</thead>
		</table>
	</div>
</div>
</div>
@push('js')
<script type="text/javascript">
	let dt_atribut = $("#table-atribut");
	const modalForm = $("#modalAddAtribut");
	$(document).ready(function () {
		try {
			$.fn.dataTable.ext.errMode = "none";
			dt_atribut = dt_atribut.DataTable({
				stateSave: true,
				lengthChange: false,
				serverSide: true,
				processing: true,
				responsive: true,
				searching: false,
				ajax: "{{ route('atribut.dt') }}",
				columns: [
					{ data: "id" },
					{ data: "name" },
					{ data: "type" },
					{ data: "desc" },
					{ data: "id" }
				],
				columnDefs: [{
					targets: 0,
					searchable: false,
					render: function (data, type, full, meta) {
						return meta.settings._iDisplayStart + meta.row + 1;
					}
				}, {
					targets: 3,
					render: function(data){
						return data??'-';
					}
				}, { //Aksi
					orderable: false,
					searchable: false,
					targets: -1,
					render: function (data, type, full) {
						return ('<div class="btn-group btn-group-sm" role="group">' +
							`<button class="btn btn-primary edit-record" wire:click="edit(${data})" data-bs-toggle="modal" data-bs-target="#modalAddAtribut">` +
							'<i class="fas fa-pen-to-square"></i>' +
							'</button>' +
							`<button class="btn btn-danger delete-record" data-id="${data}" data-name="${full['name']}">` +
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
				$.get("{{ route('atribut.count') }}", function (data) {
					$("#total-counter").text(data.total);
					$('#total-unused').text(data.unused);
				}).fail(function (xhr, st) {
					console.warn(xhr.responseJSON.message ?? st);
					notif.error(`Gagal memuat jumlah: Kesalahan HTTP ${xhr.status} ${xhr.statusText}`);
				});
			});
		} catch (dterr) {
			initError(dterr.message);
		}
	});
	modalForm.on("hidden.bs.modal", function () {
		$("#modalAddAtributLabel").html("Tambah Atribut");
		$("#addNewAtributForm")[0].reset();
		$("#attr_id").val("");
	});
	Livewire.on('toast', (r) => {
		if (r.type==='success'){
			$('.modal').modal('hide');
			if($.fn.DataTable.isDataTable("#table-atribut")) dt_atribut.draw();
		}
		notif.open({ type: r.type, message: r.msg });
	});
	Livewire.on('edit',()=>{
		$("#modalAddAtributLabel").html("Edit Atribut");
	});
</script>
@endpush