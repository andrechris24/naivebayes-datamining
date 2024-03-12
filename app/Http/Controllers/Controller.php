<?php

namespace App\Http\Controllers;

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
	public static function pso($data,$looptotal){
		$jumlah = count($data);
		$v = array_fill(0, $jumlah, 0);
		$pbest = $data;
		$gbest = $this->getGbest($data);
		//echo $gbest;
		$c1 = $c2 = 1;
		/*for($i = 0; $i<$jumlah; $i++){
			$data[$i] = rand();
			echo $data[$i]."<br>";
		}*/
		$literasi = $looptotal;
		for($i=0;$i<$literasi;$i++){
			$r1 = $r2 = (rand(0, 10)/10);
			foreach($data as $key => $value){
				$fungsi = $this->fungsi_tujuan($value);
				if($fungsi < $this->fungsi_tujuan($pbest[$key])){
					$pbest[$key] = $value;
				}
				if($fungsi < $this->fungsi_tujuan($gbest)){
					$gbest = $value;
				}
				$v[$i+1] = $i + $c1 * $r1* ($pbest[$key] - $value)  + $c2 * $r2 *($gbest - $value);
			//	echo $v[$i+1]."<br>";
			
				$hasil["data"][$i][$key] = $data[$key]; 
				$hasil["v"][$i][$key] =$v[$i+1];
				$hasil["pbest"][$i][$key] =$pbest[$key];
				
				$hasil["fungsi"][$i][$key] = $fungsi; 
				$data[$key] = $data[$key] + $v[$i+1];
			}	
			$hasil["gbest"][$i] = $gbest;
		}
	}
	public static function fungsi_tujuan($nilai){
		$hasil = pow((100 - $nilai), 2);
		return $hasil;
	}
	public static function getGbest($pbest){
		$gbest = $pbest[0];
		for($i=1; $i<count($pbest);$i++){
			if($this->fungsi_tujuan($pbest[$i]) < $this->fungsi_tujuan($gbest)){
				$gbest = $pbest[$i];
			}
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
			$d = ((double) $val) - $mean;
			$carry += $d * $d;
		}
		;
		if ($sample)
			--$n;
		return sqrt($carry / $n);
	}
}
