@if (Session::has('error') || $errors->any())
<div class="alert alert-danger alert-dismissible" role="alert">
	<i class="fa-solid fa-circle-xmark"></i> {{ Session::get('error') ?? 'Gagal:' }}
	@if($errors->any())
	<ul>@foreach($errors->all() as $error) <li>{{$error}}</li> @endforeach </ul>
	@endif
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if (Session::has('warning'))
<div class="alert alert-warning alert-dismissible" role="alert">
	<i class="fa-solid fa-triangle-exclamation"></i>
	{{ ucfirst(Session::get('warning')) }}
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if (Session::has('success'))
<div class="alert alert-success alert-dismissible" role="alert">
	<i class="fa-solid fa-circle-check"></i> {{ ucfirst(Session::get('success')) }}
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif