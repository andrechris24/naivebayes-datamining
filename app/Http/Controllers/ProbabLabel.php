<?php

namespace App\Http\Controllers;

use App\Models\Atribut;
use App\Models\Classification;
use App\Models\Probability;
use App\Models\TrainingData;
use App\Models\TestingData;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class ProbabLabel extends Controller
{
	public static array $label = [
		0 => 'Tidak Layak',	//FALSE: Tidak berhak mendapatkan bantuan sosial
		1 => 'Layak'				//TRUE : Berhak mendapatkan bantuan sosial
	];
	public static function preprocess(string $type)
	{ //Preprocessing: Mengisi nilai yang hilang (Impute missing values)
		try {
			$novals = 0;
			if ($type === 'test') $data = new TestingData();
			else $data = new TrainingData();
			foreach (Atribut::get() as $attr) {
				$missing = $data->whereNull($attr->slug)->get();
				$novals += count($missing);
				if (count($missing) > 0) {
					if ($attr->type === 'numeric') //Jika Numerik, rata-rata yang dicari
						$avg = $data->avg($attr->slug);
					else { //Jika Kategorikal, paling sering muncul yang dicari
						$most = $data->select($attr->slug)->whereNotNull($attr->slug)
							->groupBy($attr->slug)->orderByRaw("COUNT(*) desc")->first();
						// if (empty($most[$attr->slug])) continue;
					}
					$data->whereNull($attr->slug)
						->update([$attr->slug => $most[$attr->slug] ?? $avg]);
				}
			}
			return $novals;
		} catch (QueryException $e) {
			Log::error($e);
			return false;
		}
	}
	public static function hitungProbab($data)
	{//Proses perhitungan klasifikasi
		$semuadata = TrainingData::count();

		/**==================================================
		 * PRIOR
		 * ==================================================
		 * Jumlah Probabilitas berlabel Layak dan Tidak Layak
		 */ $prior = Probability::probabKelas();

		/**=====================================================================
		 * LIKELIHOOD & EVIDENCE
		 * =====================================================================
		 * Likelihood: Jumlah probabilitas dari label Layak dan Tidak Layak
		 * Evidence: Jumlah probabilitas total
		 *
		 * Likelihood dan Evidence diberi nilai 1 untuk perkalian
		 */ $likelihood['true'] = $likelihood['false'] = $evidence = 1;
		foreach (Atribut::get() as $at) {
			if ($at->type === 'categorical') {
				//Jika Kategorikal, nilai probabilitas yang dicari
				$probabilitas = Probability::firstWhere(
					'nilai_atribut_id',
					$data[$at->slug]
				);
				$probabs = [
					'true' => json_decode($probabilitas->true),
					'false' => json_decode($probabilitas->false)
				];
				$likelihood['true'] *= $probabs['true'];
				$likelihood['false'] *= $probabs['false'];
				$evidence *= TrainingData::where($at->slug, $data[$at->slug])->count() /
					$semuadata;
			} else { //Jika Numerik, Normal Distribution yang dicari
				$probabilitas = Probability::where('atribut_id', $at->id)
					->whereNull('nilai_atribut_id')->first();
				// if($probabilitas===null) continue;
				$trues = json_decode($probabilitas->true);
				$falses = json_decode($probabilitas->false);
				$total = json_decode($probabilitas->total);
				$likelihood['true'] *= self::normalDistribution(
					$data[$at->slug],
					$trues->sd,
					$trues->mean
				);
				$likelihood['false'] *= self::normalDistribution(
					$data[$at->slug],
					$falses->sd,
					$falses->mean
				);
				$evidence *= self::normalDistribution(
					$data[$at->slug],
					$total->sd,
					$total->mean
				);
			}
		}

		/**====================================================
		 * POSTERIOR
		 * ====================================================
		 * Rumus: Prior dikali Likelihood, lalu dibagi Evidence
		 * Jika Evidence 0, maka nilai posteriornya 0
		 */
		$posterior = [
			'true' => ($prior['true'] * $likelihood['true']) / $evidence,
			'false' => ($prior['false'] * $likelihood['false']) / $evidence
		];
		return [
			'true' => $posterior['true'],
			'false' => $posterior['false'],
			'predict' => $posterior['true'] >= $posterior['false']
		];
	}
	public static function resetProbab(): void
	{//Reset Probabilitas
		if (Probability::count() > 0) Probability::truncate();
		if (Classification::count() > 0) Classification::truncate();
	}
	private static function normalDistribution(int $x, float $sd, float $mean)
	{
		return (1 / ($sd * sqrt(2 * pi()))) * exp(-0.5 * pow(($x - $mean) / $sd, 2));
	}
	/**
	 * Simpangan Baku
	 *
	 * @param array $a
	 * @param bool $sample [optional] Defaults to false
	 * @return float|bool The standard deviation or false on error.
	 */
	public static function stats_standard_deviation(array $a, bool $sample = false)
	{
		$n = count($a);
		if ($n === 0) return false;
		if ($sample && $n === 1) return false;
		$mean = array_sum($a) / $n;
		$carry = 0.0;
		foreach ($a as $val) $carry += pow(((float) $val) - $mean, 2);
		if ($sample) --$n;
		return sqrt($carry / $n);
	}
}
