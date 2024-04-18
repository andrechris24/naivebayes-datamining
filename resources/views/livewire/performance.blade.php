@section('title', 'Performa')
<div class="card mb-3">
	<div class="card-header"><b>Performa Klasifikasi</b></div>
	<div class="card-body">
		<select wire:change="load" wire:model="tipe" class="form-select" id="tipe-data">
			<option value="" selected>Pilih tipe data</option>
			<option value="test">Data Testing (Data Uji)</option>
			<option value="train">Data Training (Data Latih)</option>
		</select>
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
						<td class="table-success">{{$data['tp']}}</td>
						<td class="table-danger">{{$data['fp']}}</td>
						<td>{{$data['tp'] + $data['fp']}}</td>
					</tr>
					<tr>
						<th>{{$stat[0]}}</th>
						<td class="table-danger">{{$data['fn']}}</td>
						<td class="table-success">{{$data['tn']}}</td>
						<td>{{$data['fn'] + $data['tn']}}</td>
					</tr>
					<tr>
						<th>Total</th>
						<td>{{$data['tp'] + $data['fn']}}</td>
						<td>{{$data['fp'] + $data['tn']}}</td>
						<td>{{$data['total']}}</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div id="predict-actual" wire:ignore></div>
			</div>
			<div class="col-md-6">
				<p>Hasil Akhir</p>
				<div class="progress-wrapper">
					<div class="progress-info progress-xl">
						<div class="progress-label">
							<span class="text-secondary">Akurasi</span>
						</div>
						<div class="progress-percentage">
							<span>{{round($performa['accuracy'], 2)}}%</span>
						</div>
					</div>
					<div class="progress progress-xl">
						<div class="progress-bar bg-secondary" role="progressbar"
							style="width: {{round($performa['accuracy'], 2)}}%;"
							aria-valuenow="{{round($performa['accuracy'], 2)}}" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				</div>
				<div class="progress-wrapper">
					<div class="progress-info progress-xl">
						<div class="progress-label">
							<span class="text-tertiary">Presisi</span>
						</div>
						<div class="progress-percentage">
							<span>{{round($performa['precision'], 2)}}%</span>
						</div>
					</div>
					<div class="progress progress-xl">
						<div class="progress-bar bg-tertiary" role="progressbar"
							style="width: {{round($performa['precision'], 2)}}%;"
							aria-valuenow="{{round($performa['precision'], 2)}}" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				</div>
				<div class="progress-wrapper">
					<div class="progress-info progress-xl">
						<div class="progress-label">
							<span class="text-dark">Recall</span>
						</div>
						<div class="progress-percentage">
							<span>{{round($performa['recall'], 2)}}%</span>
						</div>
					</div>
					<div class="progress progress-xl">
						<div class="progress-bar bg-dark" role="progressbar"
							style="width: {{round($performa['recall'], 2)}}%;"
							aria-valuenow="{{round($performa['recall'], 2)}}" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				</div>
				<div class="progress-wrapper">
					<div class="progress-info progress-xl">
						<div class="progress-label">
							<span class="text-success">Skor F1</span>
						</div>
						<div class="progress-percentage">
							<span>{{round($performa['f1'],2)}}%</span>
						</div>
					</div>
					<div class="progress progress-xl">
						<div class="progress-bar bg-success" role="progressbar"
							style="width: {{round($performa['f1'],2)}}%;" aria-valuenow="{{round($performa['f1'],2)}}"
							aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@push('js')
<script type="text/javascript">
	@once
	const BarOptions = {
		series: [
			{name: "{{$stat[1]}} (Prediksi)",data:[]},
			{name: "{{$stat[0]}} (Prediksi)",data:[]}
		],
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
			categories: ["{{$stat[1]}} (Aktual)", "{{$stat[0]}} (Aktual)"]
		},
		title: {
			text: 'Grafik Hasil Prediksi'
		},
		noData: {
			text: 'Pilih tipe data untuk menampilkan grafik'
		}
	};
	const bar = new ApexCharts(
		document.getElementById("predict-actual"), BarOptions
	);
	bar.render();
	@endonce
	Livewire.on('tipe-select', (chartData) => {
		bar.updateSeries([{
			name: "{{$stat[1]}} (Prediksi)",
			data: chartData.predict_true
		},{
			name: "{{$stat[0]}} (Prediksi)",
			data: chartData.predict_false
		}]);
	});
	Livewire.on('error', (err) => {
		Notiflix.Notify.failure(err.message);
		bar.updateSeries([{
			name: "{{$stat[1]}} (Prediksi)",
			data: []
		},{
			name: "{{$stat[0]}} (Prediksi)",
			data: []
		}]);
	});
</script>
@endpush