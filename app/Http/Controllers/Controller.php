<?php

namespace App\Http\Controllers;
use App\Models\Atribut;
use App\Models\TestingData;
use App\Models\TrainingData;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

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
	public static function preprocess($type): void
	{//Impute missing values
		try {
			if ($type === 'test')
				$data=new TestingData();
			else
				$data=new TrainingData();
			foreach (Atribut::get() as $attr) {
				$missing=$data->whereNull($attr->slug)->get();
				if (count($missing) > 0) {
					if ($attr->type === 'numeric')//Jika numeric, mean/rata-rata yang dicari
						$avg = $data->avg($attr->slug);
					else {//Jika categorical, modus (Terbanyak) yang dicari
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
	/**
	 * This user-land implementation follows the implementation quite strictly;
	 * it does not attempt to improve the code or algorithm in any way.
	 * 
	 * @param array $a 
	 * @param bool $sample [optional] Defaults to false
	 * @return float|bool The standard deviation or false on error.
	 */
	public static function stats_standard_deviation(array $a, $sample = false)
	{
		$n = count($a);
		if ($n === 0)
			return false;
		if ($sample && $n === 1)
			return false;
		$mean = array_sum($a) / $n;
		$carry = 0.0;
		foreach ($a as $val) {
			$carry += pow(((double) $val) - $mean, 2);
		}
		if ($sample)
			--$n;
		return sqrt($carry / $n);
	}
}
