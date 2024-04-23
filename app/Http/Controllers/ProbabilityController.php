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
		$data = Probability::get();
		$kelas = Probability::probabKelas();
		$training = TrainingData::get();
		$attribs = ['atribut' => $atribut, 'nilai' => $nilaiattr];
		$hasil = ProbabLabel::$label;
		return view(
			'main.naivebayes.probab',
			compact('attribs', 'data', 'kelas', 'training', 'hasil')
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
					$ll[$nilai->name]['true'] = ($total['true'] === 0 ? 0 :
						TrainingData::where($nilai->atribut->slug, $nilai->id)
						->where('status', true)->count() / $total['true']);
					$ll[$nilai->name]['false'] = ($total['false'] === 0 ? 0 :
						TrainingData::where($nilai->atribut->slug, $nilai->id)
						->where('status', false)->count() / $total['false']);
					$ll[$nilai->name]['total'] =
						TrainingData::where($nilai->atribut->slug, $nilai->id)->count() /
						$total['all'];
				}
				Probability::updateOrCreate([
					'atribut_id' => $nilai->atribut_id, 'nilai_atribut_id' => $nilai->id
				], [
					'true' => json_encode([0 => $ll[$nilai->name]['true']]),
					'false' => json_encode([0 => $ll[$nilai->name]['false']]),
					'total' => json_encode([0 => $ll[$nilai->name]['total']])
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
				if (
					!$sd[$nilainum->name]['true'] || !$sd[$nilainum->name]['false'] || !$sd[$nilainum->name]['all']
				) {
					$warning = true;
					continue;
				}
				Probability::updateOrCreate([
					'atribut_id' => $nilainum->id, 'nilai_atribut_id' => null
				], [
					'true' =>  json_encode([
						'mean' => $avg[$nilainum->name]['true'],
						'sd' => $sd[$nilainum->name]['true']
					]),
					'false' => json_encode([
						'mean' => $avg[$nilainum->name]['false'],
						'sd' => $sd[$nilainum->name]['false']
					]),
					'total' => json_encode([
						'mean' => $avg[$nilainum->name]['all'],
						'sd' => $sd[$nilainum->name]['all']
					])
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
}
