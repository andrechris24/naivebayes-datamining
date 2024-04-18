@section('title', 'Data Testing')
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
			<div wire:ignore.self class="modal fade" tabindex="-1" id="modalAddTesting"
				aria-labelledby="modalAddTestingLabel" role="dialog" aria-hidden="true" data-bs-backdrop="static"
				data-bs-keyboard="false">
				<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
					<div class="modal-content">
						<div class="modal-header" wire:ignore>
							<h5 id="modalAddTestingLabel" class="modal-title">
								Tambah Data Testing
							</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<form id="addNewTestingForm" wire:submit="store">
								<input type="hidden" name="id" id="test_id">
								<div class="form-floating mb-3">
									<input type="text" class="form-control @error('nama') is-invalid @enderror " id="testName"
										wire:model="nama" placeholder="Nama" required />
									<label for="testName">Nama</label>
									@error('nama')
									<div class="invalid-feedback">{{$message}}</div>
									@enderror
								</div>
								@foreach ($atribut as $attr)
								<div class="form-floating mb-3" data-bs-toggle="tooltip" title="{{$attr->desc}}">
									@if ($attr->type === 'numeric')
									<input type="number" class="form-control @error('q.'.$attr->slug) is-invalid @enderror "
										min="0" wire:model="q.{{$attr->slug}}" id="test-{{$attr->slug}}" placeholder="123" required>
									@else
									<select wire:model="q.{{$attr->slug}}"
										class="form-select @error('q.'.$attr->slug) is-invalid @enderror " id="test-{{$attr->slug}}"
										required>
										<option value="">Pilih</option>
										@foreach ($nilai->where('atribut_id', $attr->id) as $sub)
										<option value="{{$sub->id}}">{{$sub->name}}</option>
										@endforeach
									</select>
									@endif
									<label for="test-{{$attr->slug}}">{{$attr->name}}</label>
									@error('q.'.$attr->slug)
									<div class="invalid-feedback">{{$message}}</div>
									@enderror
								</div>
								@endforeach
								<div class="form-floating mb-3">
									<select wire:model="status" class="form-select @error('status') is-invalid @enderror "
										id="testResult" required>
										<option value="">Pilih</option>
										<option value="true">{{$hasil[true]}}</option>
										<option value="false">{{$hasil[false]}}</option>
										<option value="Otomatis" @if($calculated===0) disabled @endif>
											Pilih otomatis
										</option>
									</select>
									<label for="testResult">Hasil</label>
									@error('status')
									<div class="invalid-feedback">{{$message}}</div>
									@enderror
								</div>
							</form>
						</div>
						<div class="modal-footer">
							<div wire:loading wire:target="store" class="spinner-grow text-primary me-3" role="status">
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
			<div wire:ignore.self class="modal fade" tabindex="-1" id="modalImportTesting"
				aria-labelledby="modalImportTestingLabel" data-bs-backdrop="static" data-bs-keyboard="false"
				role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 id="modalImportTestingLabel" class="modal-title">
								Upload Data Testing
							</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<livewire:data-template />
							<form id="importTestingData" wire:submit="upload">
								<input type="file" class="form-control @error('dataset') is-invalid @enderror " id="testData"
									wire:model="dataset" aria-describedby="importFormats" data-bs-toggle="tooltip"
									title="Format: xls, xlsx, csv, dan tsv"
									accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.oasis.opendocument.spreadsheet,text/csv,.tsv"
									required>
								@error('dataset')
								<div class="invalid-feedback">{{$message}}</div>
								@enderror
							</form>
						</div>
						<div class="modal-footer">
							<div wire:loading wire:target="upload" class="spinner-grow text-success me-3" role="status">
								<span class="visually-hidden">Mengupload..</span>
							</div>
							<button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">
								<i class="fas fa-x"></i> Batal
							</button>
							<button type="button" class="btn btn-success" data-bs-toggle="modal"
								data-bs-target="#modalAddTesting">
								<i class="fas fa-pen"></i> Input Manual
							</button>
							<button type="submit" class="btn btn-primary data-submit" form="importTestingData">
								<i class="fas fa-upload"></i> Upload
							</button>
						</div>
					</div>
				</div>
			</div>
			<div wire:ignore.self class="modal fade" tabindex="-1" id="modalClearTesting"
				aria-labelledby="modalClearTestingLabel" data-bs-backdrop="static" data-bs-keyboard="false"
				role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
					<div class="modal-content">
						<div class="modal-header bg-danger">
							<h5 id="modalClearTestingLabel" class="modal-title text-white">
								Hapus Semua Data Testing?
							</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<p>Anda akan menghapus semua data testing yang akan mereset hasil klasifikasi terkait.</p>
						</div>
						<div class="modal-footer">
							<span wire:loading wire:target="clear">Menghapus...</span>
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
								<i class="fas fa-x"></i> Batal
							</button>
							<button type="button" class="btn btn-danger" wire:click="clear">
								<i class="fas fa-check"></i> Hapus
							</button>
						</div>
					</div>
				</div>
			</div>
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
				<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalClearTesting">
					<i class="fas fa-trash"></i> Hapus Data
				</button>
				<button type="button" wire:click="export" class="btn btn-success">
					<i class="fas fa-download"></i> Ekspor Data
				</button>
			</div>
			<table class="table table-bordered" id="table-testing" style="width: 100%" wire:ignore>
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
</div>
@push('js')
<script type="text/javascript">
	let dt_testing = $("#table-testing");
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
				ajax: "{{ route('testing.dt') }}",
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
							`<button class="btn btn-primary" wire:click="edit(${data})" data-bs-toggle="modal" data-bs-target="#modalAddTesting">` +
							'<i class="fas fa-pen-to-square"></i>' +
							'</button>' +
							`<button class="btn btn-danger delete-record" wire:click="destroy(${data})" wire:confirm="Hapus data testing ${full['nama']}?">` +
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
					Notiflix.Notify.failure(
						`Gagal memuat jumlah: Kesalahan HTTP ${xhr.status} ${xhr.statusText}`);
				});
			});
		} catch (dterr) {
			initError(dterr.message);
		}
	});
	modalForm.on("hidden.bs.modal", function () {
		$("#modalAddTestingLabel").html("Tambah Data Testing");
		$("#addNewTestingForm")[0].reset();
		$("#test_id").val("");
	});
	Livewire.on('toast', (r) => {
		if (r.type==='success'){
			$('.modal').modal('hide');
			if($.fn.DataTable.isDataTable("#table-testing")) dt_testing.draw();
		}
		notif.open({ type: r.type, message: r.msg });
	});
	Livewire.on('edit',()=>{
		$("#modalAddTestingLabel").html("Edit Data Testing");
	});
</script>
@endpush