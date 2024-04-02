@extends('layout')
@section('title','Probabilitas')
@section('content')
<div class="btn-group" role="button">
	<a href="{{route('probab.create')}}" class="btn btn-primary">
		<i class="fas fa-calculator"></i> Hitung Probabilitas
	</a>
	<a href="{{route('probab.reset')}}" class="btn btn-danger delete-record">
		<i class="fas fa-arrow-rotate-right"></i> Reset Probabilitas
	</a>
</div>
<div class="spinner-grow text-danger d-none" role="status">
	<span class="visually-hidden">Mereset...</span>
</div>
<div class="card my-3">
	<div class="card-header">Probabilitas Label Kelas</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Atribut</th>
						<th>Nilai Probabilitas</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Layak</td>
						<td>{{$kelas['l']}}</td>
					</tr>
					<tr>
						<td>Tidak Layak</td>
						<td>{{$kelas['tl']}}</td>
					</tr>
					<tr class="table-secondary">
						<td>Total</td>
						<td>
							@php
							echo $kelas['tl'] + $kelas['l'];
							$total = $training['total'];
							@endphp
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="card">
	<div class="card-header">Probabilitas Atribut Diskrit</div>
	<div class="card-body">
		@foreach ($attribs['atribut'] as $attr)
		@php
		$layak = $tidak_layak = $semua = 0.00000;
		$tot['l'] = $tot['tl'] = 0;
		$prob = $data->where('atribut_id', $attr->id)->first();
		@endphp
		<div class="table-responsive">
			<table class="table table-bordered caption-top">
				<caption>{{ $attr->name }}</caption>
				<thead>
					<tr>
						<th>Sub Atribut</th>
						<th>Layak</th>
						<th>Tidak Layak</th>
						<th>Total Probabilitas</th>
					</tr>
				</thead>
				<tbody>
					@if($attr->type==='categorical')
					@forelse($data->where('atribut_id', $attr->id) as $prob)
					@php
					$layak += $prob->layak;
					$tidak_layak += $prob->tidak_layak;
					$semua += $prob->total;
					@endphp
					<tr>
						<td>{{ $prob->nilai_atribut->name }}</td>
						<td>{{ $prob->layak }}</td>
						<td>{{ $prob->tidak_layak }}</td>
						<td>{{$prob->total}}</td>
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
						<td>{{ $layak }}</td>
						<td>{{ $tidak_layak }}</td>
						<td>{{$semua}}</td>
					</tr>
					@else
					<tr>
						<th>Data</th>
						<td>
							@foreach($training['layak'] as $l)
							@php
							if(empty($l[$attr->slug])) continue;
							$tot['l'] += $l[$attr->slug];
							echo $l[$attr->slug] . (!$loop->last ? ', ' : '');
							@endphp
							@endforeach
						</td>
						<td>
							@foreach($training['tidak_layak'] as $tl)
							@php
							if(empty($tl[$attr->slug])) continue;
							$tot['tl'] += $tl[$attr->slug];
							echo $tl[$attr->slug] . (!$loop->last ? ', ' : '');
							@endphp
							@endforeach
						</td>
						<td></td>
					</tr>
					<tr>
						<th>Jumlah</th>
						<td>{{ $tot["l"] }}</td>
						<td>{{ $tot['tl'] }}</td>
						<td>{{ $tot['l'] + $tot['tl'] }}</td>
					</tr>
					<tr>
						<th>Rata-rata</th>
						<td>{{ $prob->mean_layak ?? 0 }}</td>
						<td>{{ $prob->mean_tidak_layak ?? 0 }}</td>
						<td>{{ $prob->mean_total ?? 0 }}</td>
					</tr>
					<tr>
						<th>Simpangan Baku</th>
						<td>{{ $prob->sd_layak ?? 0 }}</td>
						<td>{{ $prob->sd_tidak_layak ?? 0 }}</td>
						<td>{{ $prob->sd_total ?? 0 }}</td>
					</tr>
					@endif
				</tbody>
			</table>
		</div>
		@endforeach
	</div>
</div>
<form action="{{ route('probab.reset') }}" method="POST" id="reset-probab">
	@csrf
	@method('DELETE')
</form>
@endsection
@section('js')
<script type="text/javascript">
	$(document).on("click", ".delete-record", function (e) {
		e.preventDefault();
		confirm.fire({
			titleText: "Reset Probabilitas?",
			text: 'Anda akan mereset hasil perhitungan probabilitas. Hasil klasifikasi akan ikut direset!'
		}).then(function (result) {
			if (result.isConfirmed){
				$("#reset-probab").submit();
				$('.spinner-grow').removeClass('d-none');
			}
		});
	})
</script>
@endsection