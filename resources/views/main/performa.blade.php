@extends('layout')
@section('title', 'Performa')
@section('content')
<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
	<li class="nav-item" role="presentation">
		<button @class(['nav-link','active'=>$data['test']['total']>0]) id="pills-testing-tab"
			data-bs-toggle="pill" data-bs-target="#pills-testing" type="button" role="tab" aria-controls="pills-testing" @if($data['test']['total']>0) aria-selected="true" 
			@else aria-selected="false" disabled @endif >
			Data Testing
		</button>
	</li>
	<li class="nav-item" role="presentation">
		<button @class(['nav-link','active'=>$data['test']['total']===0]) id="pills-training-tab"
			data-bs-toggle="pill" data-bs-target="#pills-training" type="button" role="tab"
			aria-controls="pills-training" @if($data['test']['total']===0) aria-selected="true" @else
			aria-selected="false" @endif @if($data['train']['total']===0) disabled @endif >
			Data Training
		</button>
	</li>
</ul>
<div class="tab-content" id="pills-tabContent">
	<div class="tab-pane fade @if($data['test']['total']>0) show active @endif " id="pills-testing"
		role="tabpanel" aria-labelledby="pills-testing-tab" tabindex="0">
		<div class="card mb-3">
			<div class="card-header"><b>Performa Klasifikasi Data Testing</b></div>
			<div class="card-body">
				<div class="mb-5">
					<table class="table table-bordered caption-top">
						<caption>Hasil Prediksi</caption>
						<thead class="thead-light">
							<tr>
								<th>#</th>
								<th colspan="3">Aktual</th>
							</tr>
							<tr>
								<th>Prediksi</th>
								<th>{{$stat[1]}}</th>
								<th>{{$stat[0]}}</th>
								<th>Total</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th>{{$stat[1]}}</th>
								<td class="table-success">{{$data['test']['tp']}}</td>
								<td class="table-danger">{{$data['test']['fp']}}</td>
								<td>{{$data['test']['tp'] + $data['test']['fp']}}</td>
							</tr>
							<tr>
								<th>{{$stat[0]}}</th>
								<td class="table-danger">{{$data['test']['fn']}}</td>
								<td class="table-success">{{$data['test']['tn']}}</td>
								<td>{{$data['test']['fn'] + $data['test']['tn']}}</td>
							</tr>
							<tr>
								<th>Total</th>
								<td>{{$data['test']['tp'] + $data['test']['fn']}}</td>
								<td>{{$data['test']['fp'] + $data['test']['tn']}}</td>
								<td>{{$data['test']['total']}}</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div id="predict-actual-test"></div>
					</div>
					<div class="col-md-6">
						<p>Hasil Akhir</p>
						<div class="progress-wrapper">
							<div class="progress-info progress-xl">
								<div class="progress-label">
									<span class="text-info">Akurasi</span>
								</div>
								<div class="progress-percentage">
									<span>{{round($performa['test']['accuracy'], 2)}}%</span>
								</div>
							</div>
							<div class="progress progress-xl">
								<div class="progress-bar bg-info" role="progressbar"
									style="width: {{round($performa['test']['accuracy'], 2)}}%;"
									aria-valuenow="{{round($performa['test']['accuracy'], 2)}}" 
									aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</div>
						<div class="progress-wrapper">
							<div class="progress-info progress-xl">
								<div class="progress-label">
									<span class="text-warning">Presisi</span>
								</div>
								<div class="progress-percentage">
									<span>{{round($performa['test']['precision'], 2)}}%</span>
								</div>
							</div>
							<div class="progress progress-xl">
								<div class="progress-bar bg-warning" role="progressbar"
									style="width: {{round($performa['test']['precision'], 2)}}%;"
									aria-valuenow="{{round($performa['test']['precision'], 2)}}" 
									aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</div>
						<div class="progress-wrapper">
							<div class="progress-info progress-xl">
								<div class="progress-label">
									<span class="text-danger">Recall</span>
								</div>
								<div class="progress-percentage">
									<span>{{round($performa['test']['recall'], 2)}}%</span>
								</div>
							</div>
							<div class="progress progress-xl">
								<div class="progress-bar bg-danger" role="progressbar"
									style="width: {{round($performa['test']['recall'], 2)}}%;"
									aria-valuenow="{{round($performa['test']['recall'], 2)}}" 
									aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</div>
						<div class="progress-wrapper">
							<div class="progress-info progress-xl">
								<div class="progress-label">
									<span class="text-success">Skor F1</span>
								</div>
								<div class="progress-percentage">
									<span>{{round($performa['test']['f1'],2)}}%</span>
								</div>
							</div>
							<div class="progress progress-xl">
								<div class="progress-bar bg-success" role="progressbar"
									style="width: {{round($performa['test']['f1'],2)}}%;"
									aria-valuenow="{{round($performa['test']['f1'],2)}}" 
									aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="tab-pane fade @if($data['test']['total']===0) show active @endif " id="pills-training"
		role="tabpanel" aria-labelledby="pills-training-tab" tabindex="0">
		<div class="card mb-3">
			<div class="card-header"><b>Performa Klasifikasi Data Training</b></div>
			<div class="card-body">
				<div class="mb-5">
					<table class="table table-bordered caption-top">
						<caption>Hasil Prediksi</caption>
						<thead class="thead-light">
							<tr>
								<th>#</th>
								<th colspan="3">Aktual</th>
							</tr>
							<tr>
								<th>Prediksi</th>
								<th>{{$stat[1]}}</th>
								<th>{{$stat[0]}}</th>
								<th>Total</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th>{{$stat[1]}}</th>
								<td class="table-success">{{$data['train']['tp']}}</td>
								<td class="table-danger">{{$data['train']['fp']}}</td>
								<td>{{$data['train']['tp'] + $data['train']['fp']}}</td>
							</tr>
							<tr>
								<th>{{$stat[0]}}</th>
								<td class="table-danger">{{$data['train']['fn']}}</td>
								<td class="table-success">{{$data['train']['tn']}}</td>
								<td>{{$data['train']['fn'] + $data['train']['tn']}}</td>
							</tr>
							<tr>
								<th>Total</th>
								<td>{{$data['train']['tp'] + $data['train']['fn']}}</td>
								<td>{{$data['train']['fp'] + $data['train']['tn']}}</td>
								<td>{{$data['train']['total']}}</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div id="predict-actual-train"></div>
					</div>
					<div class="col-md-6">
						<p>Hasil Akhir</p>
						<div class="progress-wrapper">
							<div class="progress-info progress-xl">
								<div class="progress-label">
									<span class="text-info">Akurasi</span>
								</div>
								<div class="progress-percentage">
									<span>{{round($performa['train']['accuracy'], 2)}}%</span>
								</div>
							</div>
							<div class="progress progress-xl">
								<div class="progress-bar bg-info" role="progressbar"
									style="width: {{round($performa['train']['accuracy'], 2)}}%;"
									aria-valuenow="{{round($performa['train']['accuracy'], 2)}}"
									aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</div>
						<div class="progress-wrapper">
							<div class="progress-info progress-xl">
								<div class="progress-label">
									<span class="text-warning">Presisi</span>
								</div>
								<div class="progress-percentage">
									<span>{{round($performa['train']['precision'], 2)}}%</span>
								</div>
							</div>
							<div class="progress progress-xl">
								<div class="progress-bar bg-warning" role="progressbar"
									style="width: {{round($performa['train']['precision'], 2)}}%;"
									aria-valuenow="{{round($performa['train']['precision'], 2)}}" 
									aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</div>
						<div class="progress-wrapper">
							<div class="progress-info progress-xl">
								<div class="progress-label">
									<span class="text-danger">Recall</span>
								</div>
								<div class="progress-percentage">
									<span>{{round($performa['train']['recall'], 2)}}%</span>
								</div>
							</div>
							<div class="progress progress-xl">
								<div class="progress-bar bg-danger" role="progressbar"
									style="width: {{round($performa['train']['recall'], 2)}}%;"
									aria-valuenow="{{round($performa['train']['recall'], 2)}}" 
									aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</div>
						<div class="progress-wrapper">
							<div class="progress-info progress-xl">
								<div class="progress-label">
									<span class="text-success">Skor F1</span>
								</div>
								<div class="progress-percentage">
									<span>{{round($performa['train']['f1'],2)}}%</span>
								</div>
							</div>
							<div class="progress progress-xl">
								<div class="progress-bar bg-success" role="progressbar"
									style="width: {{round($performa['train']['f1'],2)}}%;"
									aria-valuenow="{{round($performa['train']['f1'],2)}}" 
									aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('js')
<script type="text/javascript">
	const testBarOptions = {
		series: [{
			name: "Layak (Prediksi)",
			data: [{{$data['test']['tp']}}, {{$data['test']['fp']}}]
		}, {
			name: "Tidak Layak (Prediksi)",
			data: [{{$data['test']['fn']}}, {{$data['test']['tn']}}]
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
	const trainBarOptions = {
		series: [{
			name: "Layak (Prediksi)",
			data: [{{$data['train']['tp']}}, {{$data['train']['fp']}}]
		}, {
			name: "Tidak Layak (Prediksi)",
			data: [{{$data['train']['fn']}}, {{$data['train']['tn']}}]
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
	const barTest = new ApexCharts(
		document.getElementById("predict-actual-test"), testBarOptions
	), barTrain = new ApexCharts(
		document.getElementById("predict-actual-train"), trainBarOptions
	);
	@if($data['test']['total']>0)
	barTest.render();
	@endif
	@if($data['train']['total']>0)
	barTrain.render();
	@endif
</script>
@endsection