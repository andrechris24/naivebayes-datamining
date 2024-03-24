<?php

namespace App\Http\Controllers;

use App\Models\Classification;

class ResultController extends Controller
{
	public function index()
	{
		if (Classification::count() === 0) {
			return to_route('class.index')
				->withWarning('Lakukan klasifikasi dulu sebelum melihat hasil pengujian');
		}
		$data = $this->cm();
		$performa =$this->performa($data);
		$semua = (Classification::where('type', 'train')->count() > 0 &&
			Classification::where('type', 'test')->count() > 0);
		return view('main.performa', compact('data', 'performa', 'semua'));
	}
	private static function cm()
	{
		$ll = Classification::where('predicted', 'Layak')->where('real', 'Layak')
			->count();//True Positive
		$ltl = Classification::where('predicted', 'Tidak Layak')
			->where('real', 'Layak')->count();//False Positive
		$tll = Classification::where('predicted', 'Layak')
			->where('real', 'Tidak Layak')->count();//False Negative
		$tltl = Classification::where('predicted', 'Tidak Layak')
			->where('real', 'Tidak Layak')->count();//True Negative
		$total = $ll + $ltl + $tll + $tltl;
		return [
			'll' => $ll,
			'ltl' => $ltl,
			'tll' => $tll,
			'tltl' => $tltl,
			'total' => $total
		];
	}
	private static function performa($data){
		$accu=(($data['ll'] + $data['tltl']) / $data['total']) * 100;
		$prec=($data['ll'] / ($data['ll'] + $data['tll'])) * 100;
		$rec=($data['ll'] / ($data['ll'] + $data['ltl'])) * 100;
		$f1=2*($prec*$rec)/($prec+$rec);
		return [
			'accuracy'=>$accu,
			'precision'=>$prec,
			'recall'=>$rec,
			'f1'=>$f1
		];
	}
}
