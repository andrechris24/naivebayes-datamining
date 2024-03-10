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
