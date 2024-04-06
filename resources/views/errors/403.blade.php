@extends('errors.error')
@section('title','403 Forbidden')
@section('content')
<div class="row">
	<div class="col-12 text-center d-flex align-items-center justify-content-center">
		<h1 class="mt-5">
			<span class="fw-bolder text-primary">Tidak diperbolehkan</span>
		</h1>
		<p class="lead my-4">Anda tidak diperbolehkan untuk mengakses halaman ini.</p>
		<x-back-to-home />
	</div>
</div>
@endsection