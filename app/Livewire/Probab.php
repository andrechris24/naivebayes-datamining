<?php

namespace App\Livewire;

use App\Http\Controllers\ProbabLabel;
use App\Models\Atribut;
use App\Models\Classification;
use App\Models\NilaiAtribut;
use App\Models\Probability;
use App\Models\TrainingData;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Probab extends Component
{
	public array $probab = array();
	public array $list = ['true' => [], 'false' => [], 'all' => []];
	public array $true = array();
	public array $false = array();
	public array $semua = array();
	public array $tot = ['true' => 0, 'false' => 0];
	public array $nprob = ['true' => [], 'false' => [], 'all' => []];
	public function mount()
	{
		foreach (Atribut::get() as $attr) {
			$this->true[$attr->slug] =
				$this->false[$attr->slug] =
				$this->semua[$attr->slug] = 0.00;
			$this->tot[$attr->slug] = ['true' => 0, 'false' => 0];
			$this->list[$attr->slug] = ['true' => [], 'false' => [], 'all' => []];
			if ($attr->type === 'categorical') {
				if (Probability::count() === 0) {
					foreach (NilaiAtribut::get() as $nilai) {
						$this->nprob['true'][$nilai->id] = 0;
						$this->nprob['false'][$nilai->id] = 0;
						$this->nprob['all'][$nilai->id] = 0;
					}
				} else {
					foreach (Probability::where('atribut_id', $attr->id)->get() as $prob) {
						$this->true[$attr->slug] += $prob->true;
						$this->false[$attr->slug] += $prob->false;
						$this->semua[$attr->slug] += $prob->total;
						$this->nprob['true'][$prob->nilai_atribut_id] = $prob->true;
						$this->nprob['false'][$prob->nilai_atribut_id] = $prob->false;
						$this->nprob['all'][$prob->nilai_atribut_id] = $prob->total;
					}
				}
			} else {
				$this->probab[$attr->slug] = Probability::where('atribut_id', $attr->id)->first();
				foreach (TrainingData::get() as $tr) {
					if (empty($tr[$attr->slug])) continue;
					array_push($this->list[$attr->slug]['all'], $tr[$attr->slug]);
					if ($tr['status']) {
						array_push($this->list[$attr->slug]['true'], $tr[$attr->slug]);
						$this->tot[$attr->slug]['true'] += $tr[$attr->slug];
					} else {
						array_push($this->list[$attr->slug]['false'], $tr[$attr->slug]);
						$this->tot[$attr->slug]['false'] += $tr[$attr->slug];
					}
				}
				if ($this->probab[$attr->slug] == null) {
					$this->probab[$attr->slug] = [
						'mean_true' => 0, 'mean_false' => 0, 'mean_total' => 0,
						'sd_true' => 0, 'sd_false' => 0, 'sd_total' => 0
					];
				}
			}
		}
	}
	public function hitungProbab()
	{
		try {
			if (TrainingData::count() === 0) {
				return to_route("training.index")
					->withWarning('Masukkan Data Training dulu sebelum menghitung Probabilitas');
			}

			//Preprocessor Start
			ProbabLabel::preprocess('train');
			//Preprocessor End

			//Prior start
			$total = [
				'true' => TrainingData::where('status', true)->count(),
				'false' => TrainingData::where('status', false)->count(),
				'all' => TrainingData::count()
			];
			//Prior end

			//Likelihood Start
			foreach (NilaiAtribut::get() as $nilai) { //Categorical
				if ($nilai->atribut->type === 'categorical') {
					$ll[$nilai->name]['true'] =
						($total['true'] === 0 ? 0 :
							TrainingData::where($nilai->atribut->slug, $nilai->id)
							->where('status', true)->count() / $total['true']);
					$ll[$nilai->name]['false'] =
						($total['false'] === 0 ? 0 :
							TrainingData::where($nilai->atribut->slug, $nilai->id)
							->where('status', false)->count() / $total['false']);
					$ll[$nilai->name]['Total'] =
						TrainingData::where($nilai->atribut->slug, $nilai->id)->count() /
						$total['all'];
				}
				Probability::updateOrCreate([
					'atribut_id' => $nilai->atribut_id, 'nilai_atribut_id' => $nilai->id
				], [
					'true' => $ll[$nilai->name]['true'] ?? 0,
					'false' => $ll[$nilai->name]['false'] ?? 0,
					'total' => $ll[$nilai->name]['Total'] ?? 0
				]);
			}
			foreach (Atribut::where('type', 'numeric')->get() as $nilainum) { //Numeric
				$p = array_filter($this->getNumbers($nilainum->slug));
				if (count($p['true'])) {
					$avg[$nilainum->name]['true'] = array_sum($p['true']) / count($p['true']);
					$sd[$nilainum->name]['true'] =
						ProbabLabel::stats_standard_deviation($p['true'], true);
				}
				if (count($p['false'])) {
					$avg[$nilainum->name]['false'] =
						array_sum($p['false']) / count($p['false']);
					$sd[$nilainum->name]['false'] =
						ProbabLabel::stats_standard_deviation($p['false'], true);
				}
				$avg[$nilainum->name]['all'] = array_sum($p['all']) / count($p['all']);
				$sd[$nilainum->name]['all'] =
					ProbabLabel::stats_standard_deviation($p['all'], true);
				// if (
				// 	!$sd[$nilainum->name]['true'] || !$sd[$nilainum->name]['false'] || !$sd[$nilainum->name]['all']
				// ) {
				// 	$warning = true;
				// 	continue;
				// }
				Probability::updateOrCreate([
					'atribut_id' => $nilainum->id, 'nilai_atribut_id' => null
				], [
					'mean_true' => $avg[$nilainum->name]['true'] ?? 0,
					'mean_false' => $avg[$nilainum->name]['false'] ?? 0,
					'mean_total' => $avg[$nilainum->name]['all'] ?? 0,
					'sd_true' => $sd[$nilainum->name]['true'] ?? 0,
					'sd_false' => $sd[$nilainum->name]['false'] ?? 0,
					'sd_total' => $sd[$nilainum->name]['all'] ?? 0
				]);
			}
			//Likelihood End
			foreach (Atribut::get() as $attr) {
				$this->true[$attr->slug] =
					$this->false[$attr->slug] =
					$this->semua[$attr->slug] = 0.00;
				$this->tot[$attr->slug] = ['true' => 0, 'false' => 0];
				$this->list[$attr->slug] = ['true' => [], 'false' => [], 'all' => []];
				if ($attr->type === 'categorical') {
					foreach (Probability::where('atribut_id', $attr->id)->get() as $prob) {
						$this->true[$attr->slug] += $prob->true;
						$this->false[$attr->slug] += $prob->false;
						$this->semua[$attr->slug] += $prob->total;
						$this->nprob['true'][$prob->nilai_atribut_id] = $prob->true;
						$this->nprob['false'][$prob->nilai_atribut_id] = $prob->false;
						$this->nprob['all'][$prob->nilai_atribut_id] = $prob->total;
					}
				} else {
					$this->probab[$attr->slug] = Probability::where('atribut_id', $attr->id)
						->first();
					foreach (TrainingData::get() as $tr) {
						if (empty($tr[$attr->slug])) continue;
						array_push($this->list[$attr->slug]['all'], $tr[$attr->slug]);
						if ($tr['status']) {
							array_push($this->list[$attr->slug]['true'], $tr[$attr->slug]);
							$this->tot[$attr->slug]['true'] += $tr[$attr->slug];
						} else {
							array_push($this->list[$attr->slug]['false'], $tr[$attr->slug]);
							$this->tot[$attr->slug]['false'] += $tr[$attr->slug];
						}
					}
				}
			}
			$this->dispatch('toast', message: 'Berhasil dihitung', tipe: 'success');
		} catch (QueryException $e) {
			Log::error($e);
			$this->dispatch(
				'toast',
				message: "Gagal hitung: Kesalahan database #{$e->errorInfo[1]}",
				tipe: 'error'
			);
		}
	}
	public function resetProbab()
	{
		try {
			Probability::truncate();
			Classification::truncate();
			foreach (Atribut::get() as $attr) {
				$this->true[$attr->slug] =
					$this->false[$attr->slug] =
					$this->semua[$attr->slug] = 0.00;
				$this->tot[$attr->slug] = ['true' => 0, 'false' => 0];
				$this->list[$attr->slug] = ['true' => [], 'false' => [], 'all' => []];
				if ($attr->type === 'categorical') {
					foreach (NilaiAtribut::get() as $nilai) {
						$this->nprob['true'][$nilai->id] = 0;
						$this->nprob['false'][$nilai->id] = 0;
						$this->nprob['all'][$nilai->id] = 0;
					}
				} else {
					$this->probab[$attr->slug] = [
						'mean_true' => 0, 'mean_false' => 0, 'mean_total' => 0,
						'sd_true' => 0, 'sd_false' => 0, 'sd_total' => 0
					];
					// foreach (TrainingData::get() as $tr) {
					// 	if(empty($tr[$attr->slug])) continue;
					// 	array_push($this->list[$attr->slug]['all'],$tr[$attr->slug]);
					// 	if($tr['status']){
					// 		array_push($this->list[$attr->slug]['true'],$tr[$attr->slug]);
					// 		$this->tot[$attr->slug]['true']+=$tr[$attr->slug];
					// 	}else{
					// 		array_push($this->list[$attr->slug]['false'],$tr[$attr->slug]);
					// 		$this->tot[$attr->slug]['false']+=$tr[$attr->slug];
					// 	}
					// }
				}
			}
			$this->dispatch(
				'toast',
				message: 'Berhasil direset',
				tipe: 'success',
				reset: true
			);
		} catch (QueryException $e) {
			Log::error($e);
			$this->dispatch(
				'toast',
				message: "Gagal reset: Kesalahan database #{$e->errorInfo[1]}",
				tipe: 'error'
			);
		}
	}
	private static function getNumbers(string $col)
	{
		$data = ['true' => array(), 'false' => array(), 'all' => array()];
		foreach (TrainingData::select($col, 'status')->get() as $train) {
			if ($train['status'] == true) $data['true'][] = $train[$col];
			else $data['false'][] = $train[$col];
			$data['all'][] = $train[$col];
		}
		return $data;
	}
	public function render()
	{
		$atribut = Atribut::get();
		if (count($atribut) === 0) {
			return to_route('atribut.index')
				->withWarning('Atribut dan Nilai Atribut Kosong');
		}
		$nilaiattr = NilaiAtribut::get();
		$kelas = Probability::probabKelas();
		$hasil = ProbabLabel::$label;
		$attribs = ['atribut' => $atribut, 'nilai' => $nilaiattr];
		return view('livewire.probab', compact('attribs', 'kelas', 'hasil'));
	}
}
