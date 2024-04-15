@extends('layout')
@section('title','Probabilitas')
@section('content')
<div class="btn-group" role="button">
	<a href="{{route('probab.create')}}" class="btn btn-primary">
		<i class="fas fa-calculator"></i> Hitung
	</a>
	<a href="#modalResetProbab" class="btn btn-danger" data-bs-toggle="modal">
		<i class="fas fa-arrow-rotate-right"></i> Reset
	</a>
</div>
<div class="modal fade" tabindex="-1" id="modalResetProbab" aria-labelledby="modalResetProbabLabel"
	role="dialog" aria-hidden="true">
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
				<button type="button" class="btn btn-tertiary" data-bs-dismiss="modal">
					<i class="fas fa-x"></i> Tidak
				</button>
				<button type="submit" class="btn btn-danger" form="reset-probab">
					<i class="fas fa-check"></i> Reset
				</button>
			</div>
		</div>
	</div>
</div>
<div class="card my-3">
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
					<td>{{$hasil[true]}}</td>
					<td>{{$kelas['true']}}</td>
				</tr>
				<tr>
					<td>{{$hasil[false]}}</td>
					<td>{{$kelas['false']}}</td>
				</tr>
				<tr class="table-secondary">
					<td>Total</td>
					<td>{{$kelas['false'] + $kelas['true']}}</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<div class="card">
	<div class="card-header">Probabilitas Atribut Diskrit</div>
	<div class="card-body">
		@foreach ($attribs['atribut'] as $attr)
		@php
		$true = $false= $semua = 0.00000;
		$tot = ['true'=>0,'false' => 0];
		$list=['true'=>[],'false'=>[],'all'=>[]];
		$probab = $data->where('atribut_id', $attr->id)->first();
		@endphp
		<div class="table-responsive">
			<table class="table table-bordered caption-top">
				<caption>{{ $attr->name }}</caption>
				<thead>
					<tr>
						<th>Sub Atribut</th>
						<th>{{$hasil[true]}}</th>
						<th>{{$hasil[false]}}</th>
						<th>Total Probabilitas</th>
					</tr>
				</thead>
				<tbody>
					@if($attr->type==='categorical')
					@forelse($data->where('atribut_id', $attr->id) as $prob)
					@php
					$true += $prob->true;
					$false += $prob->false;
					$semua += $prob->total;
					@endphp
					<tr>
						<td>{{ $prob->nilai_atribut->name }}</td>
						<td>{{ $prob->true }}</td>
						<td>{{ $prob->false }}</td>
						<td>{{ $prob->total }}</td>
					</tr>
					@empty
					@foreach($attribs['nilai']->where('atribut_id', $attr->id) as $nilai)
					<tr>
						<td>{{ $nilai->name }}</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					@endforeach
					@endforelse
					<tr class="table-secondary">
						<td>Total</td>
						<td>{{ $true }}</td>
						<td>{{ $false }}</td>
						<td>{{$semua}}</td>
					</tr>
					@else
					@foreach($training as $tr)
					@php
					if(empty($tr[$attr->slug])) continue;
					array_push($list['all'],$tr[$attr->slug]);
					if($tr['status']){
					array_push($list['true'],$tr[$attr->slug]);
					$tot['true']+=$tr[$attr->slug];
					}else{
					array_push($list['false'],$tr[$attr->slug]);
					$tot['false']+=$tr[$attr->slug];
					}
					@endphp
					@endforeach
					<tr>
						<th>Data</th>
						<td class="text-wrap">{{implode(', ',$list['true'])}}</td>
						<td class="text-wrap">{{implode(', ',$list['false'])}}</td>
						<td class="text-wrap">{{implode(', ',$list['all'])}}</td>
					</tr>
					<tr>
						<th>Jumlah</th>
						<td>{{ $tot["true"] }}</td>
						<td>{{ $tot['false'] }}</td>
						<td>{{ $tot['true'] + $tot['false'] }}</td>
					</tr>
					<tr>
						<th>Rata-rata</th>
						<td>{{ $probab->mean_true ?? 0 }}</td>
						<td>{{ $probab->mean_false ?? 0 }}</td>
						<td>{{ $probab->mean_total ?? 0 }}</td>
					</tr>
					<tr>
						<th>Simpangan Baku</th>
						<td>{{ $probab->sd_true ?? 0 }}</td>
						<td>{{ $probab->sd_false ?? 0 }}</td>
						<td>{{ $probab->sd_total ?? 0 }}</td>
					</tr>
					@endif
				</tbody>
			</table>
		</div>
		@endforeach
	</div>
</div>
<form action="{{ route('probab.reset') }}" method="POST" id="reset-probab">
	@csrf @method('DELETE')
</form>
@endsection