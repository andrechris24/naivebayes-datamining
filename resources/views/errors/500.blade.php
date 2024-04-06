@extends('errors.error')
@section('title','500 Internal server Error')
@section('content')
<div class="row align-items-center">
	<div class="col-12 col-lg-5 order-2 order-lg-1 text-center text-lg-left">
		<h1 class="mt-5">500 Internal Server Error</h1>
		<p class="lead my-4">Terjadi kesalahan internal pada server</p>
		<x-back-to-home />
	</div>
	<div class="col-12 col-lg-7 order-1 order-lg-2 text-center d-flex align-items-center justify-content-center">
		<img class="img-fluid w-75" src="{{asset('assets/img/illustrations/500.svg')}}" alt="500 Server Error">
	</div>
</div>
@endsection