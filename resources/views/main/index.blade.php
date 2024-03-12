@extends('layout')
@section('title', 'Dashboard')
@section('content')
<p>Selamat datang di Aplikasi Klasifikasi Kelayakan Calon Penerima Bantuan Sosial,
	{{ auth()->user()->name }}. Aplikasi ini menggunakan Naive Bayes sebagai
	algoritma klasifikasi dengan optimasi Particle Swarm Optimization (On Progress).</p>
<div class="row">
	<div class="col-sm-6">
		<div class="card">
			<div class="card-body">
				<div class="d-flex align-items-start justify-content-between">
					<div class="content-left">
						<span>Data Training</span>
						<div class="d-flex align-items-end mt-2">
							<h3 class="mb-0 me-2">{{ $datas['train'] }}</h3>
						</div>
					</div>
					<span class="badge bg-primary rounded p-2">
						<i class="bi bi-file-earmark-text"></i>
					</span>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="card">
			<div class="card-body">
				<div class="d-flex align-items-start justify-content-between">
					<div class="content-left">
						<span>Data Testing</span>
						<div class="d-flex align-items-end mt-2">
							<h3 class="mb-0 me-2">{{ $datas['test'] }}</h3>
						</div>
					</div>
					<span class="badge bg-success rounded p-2">
						<i class="bi bi-file-earmark-text"></i>
					</span>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection