@section('title','Probabilitas')
<div class="mt-3">
	<div class="modal fade" tabindex="-1" id="modalResetProbab" aria-labelledby="modalResetProbabLabel"
		role="dialog" aria-hidden="true" wire:ignore.self>
		<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
			<div class="modal-content">
				<div class="modal-header bg-danger">
					<h5 id="modalResetProbabLabel" class="modal-title text-white">
						Reset Probabilitas?
					</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<p>Anda akan mereset perhitungan probabilitas.
						Hasil klasifikasi akan direset!</p>
				</div>
				<div class="modal-footer">
					<div wire:loading wire:target="resetProbab">Mereset...</div>
					<button type="button" class="btn btn-tertiary" data-bs-dismiss="modal">
						<i class="fas fa-x"></i> Tidak
					</button>
					<button type="button" wire:click="resetProbab" wire:loading.attr="disabled" class="btn btn-danger">
						<i class="fas fa-check"></i> Reset
					</button>
				</div>
			</div>
		</div>
	</div>
	<div class="btn-group" role="button">
		<button type="button" wire:click="hitungProbab" wire:loading.attr="disabled" class="btn btn-primary">
			<i class="fas fa-calculator"></i> Hitung Probabilitas
		</button>
		<button type="button" data-bs-toggle="modal" data-bs-target="#modalResetProbab" class="btn btn-danger">
			<i class="fas fa-arrow-rotate-right"></i> Reset Probabilitas
		</button>
	</div>
	<div wire:loading wire:target="hitungProbab">Menghitung...</div>
	<div class="card my-3" wire:key="probab-label">
		<div class="card-header">Probabilitas Label Kelas</div>
		<div class="card-body">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Atribut</th>
						<th>Nilai Probabilitas</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>{{$hasil[1]}}</td>
						<td>{{$kelas['true']}}</td>
					</tr>
					<tr>
						<td>{{$hasil[0]}}</td>
						<td>{{$kelas['false']}}</td>
					</tr>
					<tr class="table-secondary">
						<td>Total</td>
						<td>{{array_sum($kelas)}}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="card" wire:key="probab-attrib">
		<div class="card-header">Probabilitas Atribut Diskrit</div>
		<div class="card-body">
			@foreach ($attribs['atribut'] as $attr)
			<div class="table-responsive">
				<table class="table table-bordered caption-top">
					<caption>{{ $attr->name }}</caption>
					<thead>
						<tr>
							<th>Sub Atribut</th>
							<th>{{$hasil[1]}}</th>
							<th>{{$hasil[0]}}</th>
							<th>Total Probabilitas</th>
						</tr>
					</thead>
					<tbody>
						@if($attr->type==='categorical')
						@foreach($attribs['nilai']->where('atribut_id', $attr->id) as $nilai)
						<tr>
							<td>{{ $nilai->name }}</td>
							<td>{{$nprob['true'][$nilai->id]}}</td>
							<td>{{$nprob['false'][$nilai->id]}}</td>
							<td>{{$nprob['all'][$nilai->id]}}</td>
						</tr>
						@endforeach
						<tr class="table-secondary">
							<td>Total</td>
							<td>{{ $true[$attr->slug] }}</td>
							<td>{{ $false[$attr->slug] }}</td>
							<td>{{$semua[$attr->slug]}}</td>
						</tr>
						@else
						<tr>
							<th>Data</th>
							<td class="text-wrap">{{implode(', ',$list[$attr->slug]['true'])}}</td>
							<td class="text-wrap">{{implode(', ',$list[$attr->slug]['false'])}}</td>
							<td class="text-wrap">{{implode(', ',$list[$attr->slug]['all'])}}</td>
						</tr>
						<tr>
							<th>Jumlah</th>
							<td>{{ $tot[$attr->slug]["true"] }}</td>
							<td>{{ $tot[$attr->slug]['false'] }}</td>
							<td>{{ array_sum($tot[$attr->slug]) }}</td>
						</tr>
						<tr>
							<th>Rata-rata</th>
							<td>{{ $probab[$attr->slug]['mean_true'] }}</td>
							<td>{{ $probab[$attr->slug]['mean_false'] }}</td>
							<td>{{ $probab[$attr->slug]['mean_total'] }}</td>
						</tr>
						<tr>
							<th>Simpangan Baku</th>
							<td>{{ $probab[$attr->slug]['sd_true'] }}</td>
							<td>{{ $probab[$attr->slug]['sd_false'] }}</td>
							<td>{{ $probab[$attr->slug]['sd_total'] }}</td>
						</tr>
						@endif
					</tbody>
				</table>
			</div>
			@endforeach
		</div>
	</div>
</div>
@push('js')
<script type="text/javascript">
	Livewire.on('toast', (r) => {
		if(r.reset) $('#modalResetProbab').modal('hide');
		notif.open({ type: r.tipe, message: r.message });
	});
</script>
@endpush