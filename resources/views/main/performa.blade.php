@extends('layout')
@section('title','Performa')
@section('content')
<div class="card mb-3">
  <div class="card-body">
    <div class="row">
      <div class="col-lg-6">
        <table class="table table-bordered caption-top">
          <caption></caption>
          <thead>
            <tr>
              <th>#</th>
              <th colspan="2">Prediksi</th>
            </tr>
            <tr>
              <th>Aktual</th>
              <td>Layak</td>
              <td>Tidak Layak</td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th>Layak</th>
              <td>{{$data['ll']}}</td>
              <td>{{$data['ltl']}}</td>
            </tr>
            <tr>
              <th>Tidak Layak</th>
              <td>{{$data['tll']}}</td>
              <td>{{$data['tltl']}}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="col-lg-6">
        <div id="predict-actual"></div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6">
        <table class="table table-bordered caption-top">
          <caption>Confusion Matrix</caption>
          <thead>
            <tr>
              <th>#</th>
              <td>Layak</td>
              <td>Tidak Layak</td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th>Layak</th>
              <td class="table-success">0</td>
              <td class="table-danger">0</td>
            </tr>
            <tr>
              <th>Tidak Layak</th>
              <td class="table-danger">0</td>
              <td class="table-success">0</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="col-lg-6">
        <div id="cm"></div>
      </div>
    </div>
  </div>
</div>
<div class="card mb-3">
  <div class="card-header"><b>Hasil tanpa Particle Swarm Optimization</b></div>
  <div class="card-body">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th></th>
          <th>Layak</th>
          <th>Tidak Layak</th>
          <th>Hasil Akhir</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th>Akurasi</th>
          <td colspan="2">-</td>
          <td>{{$performa['accuracy']*100}}%</td>
        </tr>
        <tr>
          <th>Precision</th>
          <td>0</td>
          <td>0</td>
          <td>0%</td>
        </tr>
        <tr>
          <th>Recall</th>
          <td>0</td>
          <td>0</td>
          <td>0%</td>
        </tr>
      </tbody>
    </table>
    <div class="row">
      <div class="col-lg-6">
        <div id="perform-vector"></div>
      </div>
      <div class="col-lg-6">
        <div id="perform-radial"></div>
      </div>
    </div>
  </div>
</div>
<div class="card mb-3">
  <div class="card-header"><b>Hasil dengan Particle Swarm Optimization</b></div>
  <div class="card-body">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th></th>
          <th>Layak</th>
          <th>Tidak Layak</th>
          <th>Hasil Akhir</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th>Akurasi</th>
          <td colspan="2">-</td>
          <td>0%</td>
        </tr>
        <tr>
          <th>Presisi</th>
          <td>0</td>
          <td>0</td>
          <td>0%</td>
        </tr>
        <tr>
          <th>Recall</th>
          <td>0</td>
          <td>0</td>
          <td>0%</td>
        </tr>
      </tbody>
    </table>
    <div class="row">
      <div class="col-lg-6">
        <div id="perform-vector-pso"></div>
      </div>
      <div class="col-lg-6">
        <div id="perform-radial-pso"></div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
  const barOptions = {
    series: [
      {
        name: "Layak (Prediksi)",
        data: [{{$data['ll']}}, {{$data['tll']}}]
      },
      {
        name: "Tidak Layak (Prediksi)",
        data: [{{$data['ltl']}}, {{$data['tltl']}}]
      }
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
      categories: ["Layak (Aktual)", "Tidak Layak (Aktual)"]
    },
    title: {
      text: 'Hasil Prediksi'
    }
  };
  const bar2Opt={
    series: [
      {
        name: "Layak (Prediksi)",
        data: [44, 55]
      },
      {
        name: "Tidak Layak (Prediksi)",
        data: [76, 85]
      }
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
      categories: ["Layak (Aktual)", "Tidak Layak (Aktual)"]
    },
    title: {
      text: 'Confusion Matrix'
    }
  };
  const bar3Opt={
    series: [
      {
        name: "Layak",
        data: [0.4, 0.5, 0.8]
      },
      {
        name: "Tidak Layak",
        data: [0.6, 0.5, 0.2]
      }
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
      categories: ["Akurasi", "Presisi", "Recall"]
    },
    title: {
      text: 'Performa'
    }
  };
  const radials={
    series: [
      {{$performa['accuracy']*100}}, 
      {{$performa['precision']*100}}, 
      {{$performa['recall']*100}}
    ],
    chart: {
      type: 'radialBar'
    },
    // theme:{
    //   mode: 'auto'
    // },
    title: {
      text: "Hasil Akhir"
    },
    labels: ['Akurasi', 'Presisi', 'Recall']
  };
  const bar = new ApexCharts(document.querySelector("#predict-actual"), barOptions),
  bar2 = new ApexCharts(document.querySelector("#cm"), bar2Opt),
  bar3 = new ApexCharts(document.querySelector("#perform-vector"), bar3Opt),
  rad=new ApexCharts(document.querySelector("#perform-radial"), radials);
  bar.render();
  bar2.render();
  bar3.render();
  rad.render();
  function pso_init(y) {
    var nDims= y.min.length;
    var pos=[], vel=[], bpos=[], bval=[];
    for (var j= 0; j<y.nParticles; j++) {
      pos[j]= bpos[j]= y.min;
      var v= []; for (var k= 0; k<nDims; k++) v[k]= 0;
      vel[j]= v;
      bval[j]= Infinity;
    }
    return {
      iter: 0,
      gbpos: Infinity,
      gbval: Infinity,
      min: y.min,
      max: y.max,
      parameters: y.parameters,
      pos: pos,
      vel: vel,
      bpos: bpos,
      bval: bval,
      nParticles: y.nParticles,
      nDims: nDims
    }
  }

function pso(fn, state) {
  var y= state;
  var p= y.parameters;
  var val=[], bpos=[], bval=[], gbval= Infinity, gbpos=[];
  for (var j= 0; j<y.nParticles; j++) {
    // evaluate
    val[j]= fn.apply(null, y.pos[j]);
    // update
    if (val[j] < y.bval[j]) {
      bpos[j]= y.pos[j];
      bval[j]= val[j];
    } else {
      bpos[j]= y.bpos[j];
      bval[j]= y.bval[j]
    }
    if (bval[j] < gbval) {
      gbval= bval[j];
      gbpos= bpos[j]
    }
  }
  var rg= Math.random(), vel=[], pos=[];
  for (var j= 0; j<y.nParticles; j++) {
    // migrate
    var rp= Math.random(), ok= true;
    vel[j]= [];
    pos[j]= [];
    for (var k= 0; k < y.nDims; k++) {
      vel[j][k]= p.omega*y.vel[j][k] + p.phip*rp*(bpos[j]-y.pos[j]) + p.phig*rg*(gbpos-y.pos[j]);
      pos[j][k]= y.pos[j]+vel[j][k];
      ok= ok && y.min[k]<pos[j][k] && y.max>pos[j][k];
    }
    if (!ok){
      for (var k= 0; k < y.nDims; k++)
        pos[j][k]= y.min[k] + (y.max[k]-y.min[k])*Math.random()
    }
  }
  return {
    iter: 1+y.iter,
    gbpos: gbpos,
    gbval: gbval,
    min: y.min,
    max: y.max,
    parameters: y.parameters,
    pos: pos,
    vel: vel,
    bpos: bpos,
    bval: bval,
    nParticles: y.nParticles,
    nDims: y.nDims
  }
}

function display(text) {
  if (document) {
    var o= document.getElementById('o');
    if (!o) {
      o= document.createElement('pre');
      o.id= 'o';
      document.body.appendChild(o)
    }
    o.innerHTML+= text+'\n';
    window.scrollTo(0,document.body.scrollHeight);
  }
  if (console.log) console.log(text)
}

function reportState(state) {
  var y= state;
  display('');
  display('Iteration: '+y.iter);
  display('GlobalBestPosition: '+y.gbpos);
  display('GlobalBestValue: '+y.gbval);
}

function repeat(fn, n, y) {
  var r=y, old= y;
  if (Infinity == n)
    while ((r= fn(r)) != old) old= r;
  else
    for (var j= 0; j<n; j++) r= fn(r);
  return r;
}

function mccormick(a,b) {
  return Math.sin(a+b) + Math.pow(a-b,2) + (1 + 2.5*b - 1.5*a)
}

// state= pso_init({
//   min: [-1.5,-3], max:[4,4],
//   parameters: {omega: 0, phip: 0.6, phig: 0.3},
//   nParticles: 100
// });

// reportState(state);
// state= repeat(function(y){
//   return pso(mccormick,y)
// }, 40, state);
// reportState(state);
</script>
@endsection