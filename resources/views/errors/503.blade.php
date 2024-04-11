@extends('errors.error')
@section('title','503 Service Unavailable')
@section('content')
<div class="row align-items-center">
	<div class="col-12 col-lg-5 order-2 order-lg-1 text-center text-lg-left">
		<h1 class="mt-5">503 Service Unavailable</h1>
		<p class="lead my-4">Website sedang tidak tersedia atau dalam pemeliharaan.
			Cobalah beberapa saat lagi.</p>
		<a href="javascript:location.reload()"
			class="btn btn-gray-800 d-inline-flex align-items-center justify-content-center mb-4">
			<i class="fas fa-arrow-rotate-right"></i> Muat ulang
		</a>
	</div>
</div>
@endsection