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
		{{-- <div class="table-responsive"> --}}
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
						<td>
							@php
							echo $kelas['false'] + $kelas['true'];
							$total = $training['total'];
							@endphp
						</td>
					</tr>
				</tbody>
			</table>
			{{--
		</div> --}}
	</div>
</div>
<div class="card">
	<div class="card-header">Probabilitas Atribut Diskrit</div>
	<div class="card-body">
		@foreach ($attribs['atribut'] as $attr)
		@php
		$true = $false= $semua = 0.00000;
		$tot['true'] = $tot['false'] = 0;
		$str="";
		$prob = $data->where('atribut_id', $attr->id)->first();
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
					<tr>
						<th>Data</th>
						<td class="text-wrap">
							@foreach($training['true'] as $t)
							@php
							if(empty($t[$attr->slug])) continue;
							$tot['true'] += $t[$attr->slug];
							$str.=$t[$attr->slug].', ';
							echo $t[$attr->slug] . (!$loop->last ? ', ' : '');
							@endphp
							@endforeach
						</td>
						<td class="text-wrap">
							@foreach($training['false'] as $f)
							@php
							if(empty($f[$attr->slug])) continue;
							$tot['false'] += $f[$attr->slug];
							$str.=$f[$attr->slug].', ';
							echo $f[$attr->slug] . (!$loop->last ? ', ' : '');
							@endphp
							@endforeach
						</td>
						<td class="text-wrap">{{substr($str,0,strlen($str)-2)}}</td>
					</tr>
					<tr>
						<th>Jumlah</th>
						<td>{{ $tot["true"] }}</td>
						<td>{{ $tot['false'] }}</td>
						<td>{{ $tot['true'] + $tot['false'] }}</td>
					</tr>
					<tr>
						<th>Rata-rata</th>
						<td>{{ $prob->mean_true ?? 0 }}</td>
						<td>{{ $prob->mean_false ?? 0 }}</td>
						<td>{{ $prob->mean_total ?? 0 }}</td>
					</tr>
					<tr>
						<th>Simpangan Baku</th>
						<td>{{ $prob->sd_true ?? 0 }}</td>
						<td>{{ $prob->sd_false ?? 0 }}</td>
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