<?php

namespace App\Livewire;

use App\Http\Controllers\ProbabLabel;
use App\Models\Classification;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Performance extends Component
{
	public array $data = ['tp' => 0, 'fp' => 0, 'tn' => 0, 'fn' => 0, 'total' => 0];
	public array $performa = [
		'accuracy' => 0, 'precision' => 0, 'recall' => 0, 'f1' => 0
	];
	public string $tipe;
	public function load()
	{
		if ($this->tipe) {
			try {
				if (Classification::where('type', $this->tipe)->count() === 0){
					$this->dispatch('error',message:'Klasifikasi belum dilakukan');
					$this->data = ['tp' => 0, 'fp' => 0, 'tn' => 0, 'fn' => 0, 'total' => 0];
					$this->performa = [
						'accuracy' => 0, 'precision' => 0, 'recall' => 0, 'f1' => 0
					];
				}	else {
					$this->data = $this->cm($this->tipe);
					$this->performa = $this->performa($this->data);
					$true = [$this->data['tp'], $this->data['fp']];
					$false = [$this->data['fn'], $this->data['tn']];
					$this->dispatch(
						"tipe-select",
						predict_true: $true,
						predict_false: $false,
						performance: $this->performa
					);
				}
			} catch (QueryException $e) {
				Log::error($e);
				$this->dispatch('error',message:"Terjadi kesalahan database #{$e->errorInfo[1]}");
			}
		}
	}
	private static function cm(string $type)
	{
		$tp = Classification::where('type', $type)->where('predicted', true)
			->where('real', true)->count(); //True Positive
		$fp = Classification::where('type', $type)->where('predicted', false)
			->where('real', true)->count(); //False Positive
		$fn = Classification::where('type', $type)->where('predicted', true)
			->where('real', false)->count(); //False Negative
		$tn = Classification::where('type', $type)->where('predicted', false)
			->where('real', false)->count(); //True Negative
		$total = $tp + $fp + $fn + $tn;
		return ['tp' => $tp, 'fp' => $fp, 'fn' => $fn, 'tn' => $tn, 'total' => $total];
	}
	private static function performa(array $data)
	{
		if ($data['total'] === 0) $accu = $prec = $rec = $f1 = 0;
		else {
			$accu = (($data['tp'] + $data['tn']) / $data['total']) * 100;
			$prec = ($data['tp'] / ($data['tp'] + $data['fn'])) * 100;
			$rec = ($data['tp'] / ($data['tp'] + $data['fp'])) * 100;
			$f1 = 2 * ($prec * $rec) / ($prec + $rec);
		}
		return [
			'accuracy' => $accu, 'precision' => $prec, 'recall' => $rec, 'f1' => $f1
		];
	}
	public function render()
	{
		return view('livewire.performance', ['stat'=>ProbabLabel::$label]);
	}
}
