@extends('errors.error')
@section('title','429 Too Many Request')
@section('content')
<div class="row">
	<div class="col-12 text-center d-flex align-items-center justify-content-center">
		<i class="fas fa-stop"></i>
		<h1 class="mt-5">
			Terlalu banyak <span class="fw-bolder text-primary">permintaan</span>
		</h1>
		<p class="lead my-4">Anda mengirim terlalu banyak permintaan ke Server.
		Cobalah beberapa saat lagi.</p>
		<a href="javascript:location.reload()"
			class="btn btn-gray-800 d-inline-flex align-items-center justify-content-center mb-4">
			Muat ulang
		</a>
	</div>
</div>
@endsection