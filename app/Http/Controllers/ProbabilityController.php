<?php

namespace App\Http\Controllers;

use App\Models\Atribut;
use App\Models\Classification;
use App\Models\NilaiAtribut;
use App\Models\Probability;
use App\Models\TrainingData;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class ProbabilityController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$atribut = Atribut::get();
		if (count($atribut) === 0) {
			return to_route('atribut.index')
				->withWarning('Atribut dan Nilai Atribut Kosong');
		}
		$nilaiattr = NilaiAtribut::get();
		// if (count($nilaiattr) === 0) {
		// 	return to_route('atribut.nilai.index')
		// 		->withWarning('Tambahkan Nilai Atribut dulu sebelum menginput Dataset');
		// }
		$data = Probability::get();
		$kelas = Controller::probabKelas();
		$training = [
			'layak' => TrainingData::where('status', 'Layak')->get(),
			'tidak_layak' => TrainingData::where('status', 'Tidak Layak')->get(),
			'total' => TrainingData::count()
		];
		$attribs = ['atribut' => $atribut, 'nilai' => $nilaiattr];
		return view(
			'main.naivebayes.probab',
			compact('attribs', 'data', 'kelas', 'training')
		);
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		try {
			if (TrainingData::count() === 0) {
				return to_route("training.index")
					->withWarning('Masukkan Data Training dulu sebelum menghitung Probabilitas');
			}
			$warning = false;

			//Preprocessor Start
			Controller::preprocess('train');
			//Preprocessor End

			//Prior start
			$total = [
				'l' => TrainingData::where('status', "Layak")->count(),
				'tl' => TrainingData::where('status', "Tidak Layak")->count(),
				'all' => TrainingData::count()
			];
			//Prior end

			//Likelihood Start
			foreach (NilaiAtribut::get() as $nilai) { //Categorical
				if ($nilai->atribut->type === 'categorical') {
					$ll[$nilai->name]['Layak'] =
						($total['l'] === 0 ? 0 :
							TrainingData::where($nilai->atribut->slug, $nilai->id)
							->where('status', 'Layak')->count() / $total['l']);
					$ll[$nilai->name]['Tidak Layak'] =
						($total['tl'] === 0 ? 0 :
							TrainingData::where($nilai->atribut->slug, $nilai->id)
							->where('status', 'Tidak Layak')->count() / $total['tl']);
					$ll[$nilai->name]['Total'] =
						TrainingData::where($nilai->atribut->slug, $nilai->id)->count() /
						$total['all'];
				}
				Probability::updateOrCreate([
					'atribut_id' => $nilai->atribut_id,
					'nilai_atribut_id' => $nilai->id
				], [
					'layak' => $ll[$nilai->name]['Layak'] ?? 0,
					'tidak_layak' => $ll[$nilai->name]['Tidak Layak'] ?? 0,
					'total' => $ll[$nilai->name]['Total'] ?? 0
				]);
			}
			foreach (Atribut::where('type', 'numeric')->get() as $nilainum) { //Numeric
				$p = array_filter($this->getNumbers($nilainum->slug));
				if (count($p['l'])) {
					$avg[$nilainum->name]['l'] = array_sum($p['l']) / count($p['l']);
					$sd[$nilainum->name]['l'] =
						Controller::stats_standard_deviation($p['l'], true);
				}
				if (count($p['tl'])) {
					$avg[$nilainum->name]['tl'] = array_sum($p['tl']) / count($p['tl']);
					$sd[$nilainum->name]['tl'] =
						Controller::stats_standard_deviation($p['tl'], true);
				}
				$avg[$nilainum->name]['all'] = array_sum($p['all']) / count($p['all']);
				$sd[$nilainum->name]['all'] =
					Controller::stats_standard_deviation($p['all'], true);
				if (
					!$sd[$nilainum->name]['l'] || !$sd[$nilainum->name]['tl'] || !$sd[$nilainum->name]['all']
				) {
					$warning = true;
					continue;
				}
				Probability::updateOrCreate([
					'atribut_id' => $nilainum->id,
					'nilai_atribut_id' => null
				], [
					'mean_layak' => $avg[$nilainum->name]['l'] ?? 0,
					'mean_tidak_layak' => $avg[$nilainum->name]['tl'] ?? 0,
					'mean_total' => $avg[$nilainum->name]['all'] ?? 0,
					'sd_layak' => $sd[$nilainum->name]['l'] ?? 0,
					'sd_tidak_layak' => $sd[$nilainum->name]['tl'] ?? 0,
					'sd_total' => $sd[$nilainum->name]['all'] ?? 0
				]);
			}
			//Likelihood End

			if ($warning) {
				return back()
					->withWarning('Satu atau lebih atribut probabilitas Gagal dihitung');
			}
			return back()->withSuccess('Probabilitas berhasil dihitung');
		} catch (QueryException $e) {
			Log::error($e);
			return back()->withError('Gagal hitung:')->withErrors($e->errorInfo);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy()
	{
		try {
			Probability::truncate();
			Classification::truncate();
			return back()->withSuccess('Perhitungan probabilitas sudah direset');
		} catch (QueryException $e) {
			return back()->withError('Gagal reset:')->withErrors($e);
		}
	}
	public static function getNumbers(string $col)
	{
		$data = [];
		foreach (TrainingData::select($col, 'status')->get() as $train) {
			if ($train->status === 'Layak')
				$data['l'][] = $train[$col];
			else
				$data['tl'][] = $train[$col];
			$data['all'][] = $train[$col];
		}
		return $data;
	}
}
