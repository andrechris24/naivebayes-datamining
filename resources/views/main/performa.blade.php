@extends('layout')
@section('title','Performa')
@section('content')
<div class="card mb-3">
	<div class="card-header"><b>Hasil</b></div>
	<div class="card-body">
		<div class="row">
			<div class="col-lg-6">
				<table class="table table-bordered caption-top">
					<caption></caption>
					<thead>
						<tr>
							<th>{{round($performa['accuracy'], 2)}}%</th>
							<th colspan="2">Aktual</th>
							<th>Presisi</th>
						</tr>
						<tr>
							<th>Prediksi</th>
							<th>Layak</th>
							<th>Tidak Layak</th>
							<th>{{round($performa['precision'], 2)}}%</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th>Layak</th>
							<td class="table-success">{{$data['ll']}}</td>
							<td class="table-danger">{{$data['tll']}}</td>
							<td>{{round($data['pl'], 2)}}%</td>
						</tr>
						<tr>
							<th>Tidak Layak</th>
							<td class="table-danger">{{$data['ltl']}}</td>
							<td class="table-success">{{$data['tltl']}}</td>
							<td>{{round($data['ptl'], 2)}}%</td>
						</tr>
						<tr>
							<th>Recall</th>
							<td>{{round($data['rl'], 2)}}%</td>
							<td>{{round($data['rtl'], 2)}}%</td>
							<td>{{round($performa['recall'], 2)}}%</td>
					</tbody>
				</table>
			</div>
			<div class="col-lg-6"><div id="predict-actual"></div></div>
		</div>
		<div class="row">
			<div class="col-lg-6"><div id="perform-vector"></div></div>
			<div class="col-lg-6"><div id="perform-radial"></div></div>
		</div>
	</div>
</div>
@endsection
@section('js')
<script type="text/javascript">
	const barOptions = {
		series: [{
			name: "Layak (Prediksi)",
			data: [{{$data['ll']}}, {{$data['tll']}}]
		}, {
			name: "Tidak Layak (Prediksi)",
			data: [{{$data['ltl']}}, {{$data['tltl']}}]
		}],
		chart: {
			type: "bar"
		},
		dataLabels: {
			enabled: false
		},
		tooltip: {
			theme: 'dark'
		},
		xaxis: {
			categories: ["Layak (Aktual)", "Tidak Layak (Aktual)"]
		},
		title: {
			text: 'Hasil Prediksi'
		}
	};
	const vectorOptions = {
		series: [{
			name: "Layak",
			data: [{{$data['al']}}, {{$data['pl']}}, {{$data['rl']}}]
		}, {
			name: "Tidak Layak",
			data: [{{$data['atl']}}, {{$data['ptl']}}, {{$data['rtl']}}]
		}],
		chart: {
			type: "bar"
		},
		dataLabels: {
			enabled: false
		},
		tooltip: {
			theme: 'dark'
		},
		xaxis: {
			categories: ["Akurasi", "Presisi", "Recall"]
		},
		title: {
			text: 'Performance Vector'
		}
	};
	const radials={
		series: [
			{{$performa['accuracy']}}, 
			{{$performa['precision']}}, 
			{{$performa['recall']}}
		],
		chart: {
			type: 'radialBar'
		},
		// theme:{
		//   mode: 'auto'
		// },
		title: {
			text: "Hasil Akhir"
		},
		labels: ['Akurasi', 'Presisi', 'Recall']
	};
	const bar = new ApexCharts(document.querySelector("#predict-actual"), barOptions),
	performBar = new ApexCharts(document.querySelector("#perform-vector"), vectorOptions),
	rad = new ApexCharts(document.querySelector("#perform-radial"), radials);
	bar.render();
	performBar.render();
	rad.render();
</script>
@endsection