<?php

namespace App\Http\Controllers;

use App\Models\Classification;

class ResultController extends Controller
{
	public function __invoke()
	{//Tampilkan halaman Performa
		if (Classification::count() === 0) {
			return to_route('class.index')->withWarning(
				'Lakukan klasifikasi dulu sebelum melihat performa klasifikasi'
			);
		}
		$data = ['train' => $this->cm('train'), 'test' => $this->cm('test')];
		$performa = [
			'train' => $this->performa($data['train']),
			'test' => $this->performa($data['test'])
		];
		$stat = ProbabLabel::$label;
		return view('main.performa', compact('data', 'performa', 'stat'));
	}
	private static function cm(string $type)
	{//Hitung data Confusion Matrix
		$tp = Classification::where('type', $type)->where('predicted', true)
			->where('real', true)->count(); //True Positive
		$fp = Classification::where('type', $type)->where('predicted', true)
			->where('real', false)->count(); //False Positive
		$fn = Classification::where('type', $type)->where('predicted', false)
			->where('real', true)->count(); //False Negative
		$tn = Classification::where('type', $type)->where('predicted', false)
			->where('real', false)->count(); //True Negative
		$total = $tp + $fp + $fn + $tn;
		return [
			'tp' => $tp, 'fp' => $fp, 'fn' => $fn, 'tn' => $tn, 'total' => $total
		];
	}
	private static function performa(array $data)
	{//Hitung Akurasi, Presisi, Recall, dan F1-score
		if ($data['total'] === 0) $accu = $prec = $rec = $f1 = 0;
		else {
			$accu = (($data['tp'] + $data['tn']) / $data['total']) * 100;
			$prec = ($data['tp'] / ($data['tp'] + $data['fp'])) * 100;
			$rec = ($data['tp'] / ($data['tp'] + $data['fn'])) * 100;
			$f1 = 2 * ($prec * $rec) / ($prec + $rec);
		}
		return [
			'accuracy' => $accu, 'precision' => $prec, 'recall' => $rec, 'f1' => $f1
		];
	}
}
