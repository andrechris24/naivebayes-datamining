<?php

namespace App\Livewire;

use App\Exports\ClassificationExport;
use App\Http\Controllers\ProbabLabel;
use App\Models\Classification;
use App\Models\Probability;
use App\Models\TestingData;
use App\Models\TrainingData;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\Component;

class Classify extends Component
{
	public string $type = 'test';
	public function calc()
	{
		$this->validate(Classification::$rule);
		try {
			$semuadata = $this->getData($this->type); //Dataset
			if (Probability::count() === 0)
				$this->dispatch('toast', type: 'error', msg: 'Probabilitas belum dihitung');
			else if (!$semuadata)
				$this->dispatch('toast', type: 'error', msg: 'Tipe Data yang dipilih kosong');
			else {
				//Preprocessor Start
				if ($this->type === 'test') ProbabLabel::preprocess('test');
				//Preprocessor End

				foreach ($semuadata as $dataset) {
					$klasifikasi = ProbabLabel::hitungProbab($dataset);
					Classification::updateOrCreate([
						'name' => $dataset->nama, 'type' => $this->type
					], [
						'true' => $klasifikasi['true'],
						'false' => $klasifikasi['false'],
						'predicted' => $klasifikasi['predict'],
						'real' => $dataset->status
					]);
				}
				$this->dispatch('toast', type: 'success', msg: 'Berhasil dihitung');
			}
		} catch (QueryException $e) {
			Log::error($e);
			$this->dispatch(
				'toast',
				type: 'error',
				msg: "Gagal hitung: Kesalahan database #{$e->errorInfo[2]}"
			);
		}
	}
	public function resetCalc()
	{
		$this->validate(Classification::$rule);
		try {
			if ($this->type === 'all') Classification::truncate();
			else Classification::where('type', $this->type)->delete();
			$this->dispatch('toast', type: 'success', msg: 'Berhasil direset');
		} catch (QueryException $e) {
			Log::error($e);
			$this->dispatch(
				'toast',
				type: 'error',
				msg: "Gagal reset: Kesalahan database #{$e->errorInfo[2]}"
			);
		}
	}
	public function ekspor($tipe)
	{
		return Excel::download(
			new ClassificationExport($tipe),
			"klasifikasi_{$tipe}.xlsx"
		);
	}
	private function getData(string $type)
	{
		if ($type === 'train') {
			if (TrainingData::count() === 0) return false;
			$data = TrainingData::get();
		} else { //Default
			if (TestingData::count() === 0) return false;
			$data = TestingData::get();
		}
		return $data;
	}
	public function render()
	{
		return view('livewire.classify', ['hasil' => ProbabLabel::$label]);
	}
}
