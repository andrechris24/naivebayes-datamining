<?php

namespace App\Http\Controllers;

use App\Models\Classification;

class ResultController extends Controller
{
	public function index()
	{
		if (Classification::count() === 0) {
			return to_route('class.index')
				->withWarning('Lakukan klasifikasi dulu sebelum melihat performa klasifikasi');
		}
		$data['train'] = $this->cm('train');
		$data['test'] = $this->cm('test');
		$performa['train'] = $this->performa($data['train']);
		$performa['test'] = $this->performa($data['test']);
		return view('main.performa', compact('data', 'performa'));
	}
	private static function cm($type)
	{
		$ll = Classification::where('type', $type)->where('predicted', 'Layak')
			->where('real', 'Layak')->count(); //True Positive
		$ltl = Classification::where('type', $type)->where('predicted', 'Tidak Layak')
			->where('real', 'Layak')->count(); //False Positive
		$tll = Classification::where('type', $type)->where('predicted', 'Layak')
			->where('real', 'Tidak Layak')->count(); //False Negative
		$tltl = Classification::where('type', $type)->where('predicted', 'Tidak Layak')
			->where('real', 'Tidak Layak')->count(); //True Negative
		$total = $ll + $ltl + $tll + $tltl;
		return [
			'll' => $ll,
			'ltl' => $ltl,
			'tll' => $tll,
			'tltl' => $tltl,
			'total' => $total
		];
	}
	private static function performa($data)
	{
		if ($data['total'] === 0) $accu = $prec = $rec = $f1 = 0;
		else {
			$accu = (($data['ll'] + $data['tltl']) / $data['total']) * 100;
			$prec = ($data['ll'] / ($data['ll'] + $data['tll'])) * 100;
			$rec = ($data['ll'] / ($data['ll'] + $data['ltl'])) * 100;
			$f1 = 2 * ($prec * $rec) / ($prec + $rec);
		}
		return [
			'accuracy' => $accu, 'precision' => $prec, 'recall' => $rec, 'f1' => $f1
		];
	}
}
