@extends('errors.error')
@section('title','404 Not Found')
@section('content')
<div class="row">
	<div class="col-12 text-center d-flex align-items-center justify-content-center">
		<img class="img-fluid w-75" src="{{asset('assets/img/illustrations/404.svg')}}" alt="404 not found">
		<h1 class="mt-5">
			Halaman tidak <span class="fw-bolder text-primary">ditemukan</span>
		</h1>
		<p class="lead my-4">Halaman atau Data yang Anda cari tidak ditemukan.</p>
		<x-back-to-home />
	</div>
</div>
@endsection