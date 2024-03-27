<?php

namespace App\Http\Controllers;

use App\Models\Atribut;
use App\Models\Probability;
use App\Models\TestingData;
use App\Models\TrainingData;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;

class Controller extends BaseController
{
	use AuthorizesRequests, ValidatesRequests;
	public static function probabKelas()
	{
		$total = TrainingData::count();
		$layak = TrainingData::where('status', 'Layak')->count() / $total;
		$tidak_layak = TrainingData::where('status', 'Tidak Layak')->count() / $total;
		return ['l' => $layak, 'tl' => $tidak_layak];
	}
	public static function preprocess(string $type): void
	{ //Impute missing values
		try {
			if ($type === 'test')
				$data = new TestingData();
			else
				$data = new TrainingData();
			foreach (Atribut::get() as $attr) {
				$missing = $data->whereNull($attr->slug)->get();
				if (count($missing) > 0) {
					if ($attr->type === 'numeric') //Jika Numerik, rata-rata yang dicari
						$avg = $data->avg($attr->slug);
					else { //Jika Kategorikal, terbanyak yang dicari
						$most = $data->select($attr->slug)->groupBy($attr->slug)
							->orderByRaw("COUNT(*) desc")->first();
					}
					$data->whereNull($attr->slug)
						->update([$attr->slug => $most[$attr->slug] ?? $avg]);
				}
			}
		} catch (QueryException $e) {
			Log::error($e);
		}
	}
	public function fungsi_tujuan($nilai)
	{
		return pow((100 - $nilai), 2);
	}
	public function getGbest($pbest)
	{
		$gbest = $pbest[0];
		for ($i = 1; $i < count($pbest); $i++) {
			if ($this->fungsi_tujuan($pbest[$i]) < $this->fungsi_tujuan($gbest))
				$gbest = $pbest[$i];
		}
		return $gbest;
	}
	public function hitungProbab($data)
	{
		$semuadata = TrainingData::count();

		/**==================================================
		 * PRIOR
		 * ==================================================
		 * Jumlah Probabilitas berlabel Layak dan Tidak Layak
		 */
		$prior = $this->probabKelas();

		/**========================================================================
		 * LIKELIHOOD & EVIDENCE
		 * ========================================================================
		 * Likelihood: Jumlah probabilitas dari label Layak dan Tidak Layak
		 * Evidence: Jumlah probabilitas dari semua label
		 * 
		 * Likelihood dan Evidence diinisialisasi dengan angka 1 untuk perkalian
		 */
		$likelihood['l'] = $likelihood['tl'] = $evidence = 1;
		foreach (Atribut::get() as $at) {
			if ($at->type === 'categorical') {
				//Jika Kategorikal, nilai probabilitas yang dicari
				$probabilitas = Probability::firstWhere(
					'nilai_atribut_id',
					$data[$at->slug]
				);
				$likelihood['l'] *= $probabilitas['layak'];
				$likelihood['tl'] *= $probabilitas['tidak_layak'];
				$evidence *= TrainingData::where($at->slug, $data[$at->slug])->count() /
					$semuadata;
			} else { //Jika Numerik, Normal Distribution yang dicari
				$probabilitas = Probability::where('atribut_id', $at->id)
					->whereNull('nilai_atribut_id')->first();
				$likelihood['l'] *= $this->normalDistribution(
					$data[$at->slug],
					$probabilitas->sd_layak,
					$probabilitas->mean_layak
				);
				$likelihood['tl'] *= $this->normalDistribution(
					$data[$at->slug],
					$probabilitas->sd_tidak_layak,
					$probabilitas->mean_tidak_layak
				);
				$evidence *= $this->normalDistribution(
					$data[$at->slug],
					$probabilitas->sd_total,
					$probabilitas->mean_total
				);
			}
		}

		/**====================================================
		 * POSTERIOR
		 * ====================================================
		 * Rumus: Prior dikali Likelihood, lalu dibagi Evidence
		 * Jika Evidence 0, maka nilai posteriornya 0
		 */
		$posterior['layak'] = ($prior['l'] * $likelihood['l']) / $evidence;
		$posterior['tidak_layak'] = ($prior['tl'] * $likelihood['tl']) / $evidence;

		$predict = $posterior['layak'] >= $posterior['tidak_layak'] ? 'Layak' : "Tidak Layak";
		return [
			'layak' => $posterior['layak'],
			'tidak_layak' => $posterior['tidak_layak'],
			'predict' => $predict
		];
	}
	private function normalDistribution($x, float $sd, float $mean)
	{
		return (1 / ($sd * sqrt(2 * pi()))) * exp(-0.5 * pow(($x - $mean) / $sd, 2));
	}
	/**
	 * This user-land implementation follows the implementation quite strictly;
	 * it does not attempt to improve the code or algorithm in any way.
	 * 
	 * @param array $a 
	 * @param bool $sample [optional] Defaults to false
	 * @return float|bool The standard deviation or false on error.
	 */
	public static function stats_standard_deviation(array $a, bool $sample = false)
	{
		$n = count($a);
		if ($n === 0)
			return false;
		if ($sample && $n === 1)
			return false;
		$mean = array_sum($a) / $n;
		$carry = 0.0;
		foreach ($a as $val) {
			$carry += pow(((float) $val) - $mean, 2);
		}
		if ($sample)
			--$n;
		return sqrt($carry / $n);
	}
}
