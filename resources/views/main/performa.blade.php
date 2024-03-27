@extends('layout')
@section('title', 'Performa')
@section('content')
@if($semua)
<div class="alert alert-info" role="alert">
	<i class="bi bi-info-circle"></i>
	Performa yang ditampilkan adalah performa hasil klasifikasi dari semua jenis data.
	Reset salah satu klasifikasi untuk menampilkan performa dari salah satu jenis data saja.
</div>
@endif
<div class="card mb-3">
	<div class="card-header"><b>Hasil</b></div>
	<div class="card-body">
		<div class="row">
			<div class="col-lg-6">
				<table class="table table-bordered caption-top">
					<caption>Hasil Prediksi</caption>
					<thead>
						<tr>
							<th>#</th>
							<th colspan="3">Aktual</th>
						</tr>
						<tr>
							<th>Prediksi</th>
							<th>Layak</th>
							<th>Tidak Layak</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th>Layak</th>
							<td class="table-success">{{$data['ll']}}</td>
							<td class="table-danger">{{$data['tll']}}</td>
							<td>{{$data['ll'] + $data['tll']}}</td>
						</tr>
						<tr>
							<th>Tidak Layak</th>
							<td class="table-danger">{{$data['ltl']}}</td>
							<td class="table-success">{{$data['tltl']}}</td>
							<td>{{$data['ltl'] + $data['tltl']}}</td>
						</tr>
						<tr>
							<th>Total</th>
							<td>{{$data['ll'] + $data['ltl']}}</td>
							<td>{{$data['tll'] + $data['tltl']}}</td>
							<td>{{$data['total']}}</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col-lg-6">
				<table class="table table-bordered caption-top">
					<caption>Performa</caption>
					<tbody>
						<tr>
							<th>Akurasi</th>
							<td>{{round($performa['accuracy'], 2)}}%</td>
						</tr>
						<tr>
							<th>Presisi</th>
							<td>{{round($performa['precision'], 2)}}%</td>
						</tr>
						<tr>
							<th>Recall</th>
							<td>{{round($performa['recall'], 2)}}%</td>
						</tr>
						<tr>
							<th>Skor F1</th>
							<td>{{round($performa['f1'],2)}}%</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6">
				<div id="predict-actual"></div>
			</div>
			<div class="col-lg-6">
				<div id="perform-radial"></div>
			</div>
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
			type: "bar",
			foreColor: '#777'
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
	const radials = {
		series: [
			{{round($performa['accuracy'], 2)}}, 
			{{round($performa['precision'], 2)}}, 
			{{round($performa['recall'], 2)}},
			{{round($performa['f1'],2)}}
		],
		chart: {
			type: 'radialBar',
			foreColor: '#777'
		},
		title: {
			text: "Hasil Akhir"
		},
		plotOptions: {
			radialBar: {
				dataLabels: {
					total: {
						show: true,
						label: "Total Data",
						formatter: function(){
							return {{$data['total']}};
						}
					}
				}
			}
		},
		labels: ['Akurasi', 'Presisi', 'Recall', 'Skor F1']
	};
	const bar = new ApexCharts(document.getElementById("predict-actual"), barOptions),
	rad = new ApexCharts(document.getElementById("perform-radial"), radials);
	bar.render();
	rad.render();
</script>
@endsection