@extends('layout')
@section('title','Probabilitas')
@section('content')
<div class="btn-group" role="button">
  <a href="{{route('probab.create')}}" class="btn btn-primary">
    <i class="bi bi-calculator"></i> Hitung Probabilitas
  </a>
  <a href="{{route('probab.reset')}}" class="btn btn-danger delete-record">
    <i class="bi bi-arrow-clockwise"></i> Reset Probabilitas
  </a>
</div>
<div class="spinner-grow text-danger d-none" role="status">
  <span class="visually-hidden">Mereset...</span>
</div>
<div class="card my-3">
  <div class="card-header">Probabilitas Label Kelas</div>
  <div class="card-body">
    <table class="table table-bordered" id="table-training">
      <thead>
        <tr>
          <th>Atribut</th>
          <th>Nilai Probabilitas</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Layak</td>
          <td>{{$kelas['l']}}</td>
        </tr>
        <tr>
          <td>Tidak Layak</td>
          <td>{{$kelas['tl']}}</td>
        </tr>
        <tr class="table-secondary">
          <td>Total</td>
          <td>
            @php
            echo $kelas['tl']+$kelas['l'];
            $total=$training['total'];
            @endphp
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<div class="card">
  <div class="card-header">Probabilitas Atribut Diskrit</div>
  <div class="card-body">
    @foreach ($attribs['atribut'] as $attr)
    @php
    $layak=$tidak_layak=0.00000;
    @endphp
    <table class="table table-bordered caption-top">
      <caption>{{$attr->name}}</caption>
      <thead>
        <tr>
          <th>#</th>
          <th>Layak</th>
          <th>Tidak Layak</th>
        </tr>
      </thead>
      <tbody>
        @if($attr->type==='categorical')
        @forelse($data->where('atribut_id',$attr->id) as $prob)
        @php
        $layak+=$prob->layak/$total;
        $tidak_layak+=$prob->tidak_layak/$total;
        @endphp
        <tr>
          <td>{{$prob->nilai_atribut->name}}</td>
          <td>{{$prob->layak/$total}}</td>
          <td>{{$prob->tidak_layak/$total}}</td>
        </tr>
        @empty
        @foreach($attribs['nilai']->where('atribut_id',$attr->id) as $nilai)
        <tr>
          <td>{{$nilai->name}}</td>
          <td>0</td>
          <td>0</td>
        </tr>
        @endforeach
        @endforelse
        <tr class="table-secondary">
          <td>Total</td>
          <td>{{$layak??0}}</td>
          <td>{{$tidak_layak??0}}</td>
        </tr>
        @else
        <tr>
          <th>{{$attr->name}}</th>
          <td>
            @foreach($training['layak'] as $l)
            {{$l[$attr->slug].(!$loop->last?', ':'')}}
            @endforeach
          </td>
          <td>
            @foreach($training['tidak_layak'] as $tl)
            {{$tl[$attr->slug].(!$loop->last?', ':'')}}
            @endforeach
          </td>
        </tr>
        @forelse($data->where('atribut_id',$attr->id) as $prob)
        <tr>
          <th>Rata-rata</th>
          <td>{{$prob->mean_layak??0}}</td>
          <td>{{$prob->mean_tidak_layak??0}}</td>
        </tr>
        <tr>
          <th>Standard Deviation</th>
          <td>{{$prob->sd_layak??0}}</td>
          <td>{{$prob->sd_tidak_layak??0}}</td>
        </tr>
        @empty
        <tr>
          <th>Rata-rata</th>
          <td>0</td>
          <td>0</td>
        </tr>
        <tr>
          <th>Standard Deviation</th>
          <td>0</td>
          <td>0</td>
        </tr>
        @endforelse
        @endif
      </tbody>
    </table>
    @endforeach
  </div>
</div>
<form action="{{route('probab.reset')}}" method="POST" id="reset-probab">
  @csrf
  @method('DELETE')
</form>
@endsection
@section('js')
<script type="text/javascript">
  $(document).on("click", ".delete-record", function (e) {
		e.preventDefault();
		confirm.fire({
			title: "Reset Probabilitas?",
			text: 'Anda akan mereset hasil perhitungan probabilitas.'
		}).then(function (result) {
      if (result.isConfirmed){
        $("#reset-probab").submit();
        $('.spinner-grow').removeClass('d-none');
      }
		});
	})
</script>
@endsection