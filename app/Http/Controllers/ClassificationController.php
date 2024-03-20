<?php

namespace App\Http\Controllers;

use App\Models\Classification;
use App\Models\Atribut;
use App\Models\Probability;
use App\Models\TestingData;
use App\Models\TrainingData;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class ClassificationController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		return view('main.naivebayes.classify');
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create(Request $request)
	{
		$request->validate(Classification::$rule);
		try {
			if (Probability::count() === 0)
				return response()->json(['message' => 'Probabilitas belum dihitung'], 400);

			//Preprocessor Start
			if ($request->type === 'test') Controller::preprocess('test');
			//Preprocessor End

			//Prior start
			$semuadata = $this->getData($request->type);
			$probab = Controller::probabKelas();
			//Prior end

			if (!$semuadata) {
				return response()->json([
					'message' => 'Tipe Data yang dipilih kosong'
				], 400);
			}
			foreach ($semuadata as $dataset) {
				//Likelihood & Evidence Start
				$plf['l'] = $plf['tl'] = $evi = 1;
				foreach (Atribut::get() as $at) {
					if ($at->type === 'categorical') {
						$probabilitas = Probability::firstWhere(
							'nilai_atribut_id',
							$dataset[$at->slug]
						);
						$plf['l'] *= $probabilitas['layak'];
						$plf['tl'] *= $probabilitas['tidak_layak'];
						$evi *= TrainingData::where($at->slug, $dataset[$at->slug])->count() /
							count($semuadata);
					} else {//Numeric
						$probabilitas = Probability::where('atribut_id', $at->id)
							->whereNull('nilai_atribut_id')->first();
						$plf['l'] *= $this->normalDistribution(
							$dataset[$at->slug],
							$probabilitas->sd_layak,
							$probabilitas->mean_layak
						);
						$plf['tl'] *= $this->normalDistribution(
							$dataset[$at->slug],
							$probabilitas->sd_tidak_layak,
							$probabilitas->mean_tidak_layak
						);
						$evi *= $this->normalDistribution(
							$dataset[$at->slug],
							$probabilitas->sd_total,
							$probabilitas->mean_total
						);
					}
				}
				//Likelihood & Evidence End

				//Posterior Start
				$p['layak'] = ($evi === 0 ? 0 : (($plf['l'] * $probab['l']) / $evi));
				$p['tidak_layak'] = ($evi === 0 ? 0 : (($plf['tl'] * $probab['tl']) / $evi));
				//Posterior End

				$predict = $p['layak'] >= $p['tidak_layak'] ? 'Layak' : "Tidak Layak";
				Classification::updateOrCreate([
					'name' => $dataset->nama,
					'type' => $request->type
				], [
					'layak' => $p['layak'],
					'tidak_layak' => $p['tidak_layak'],
					'predicted' => $predict,
					'real' => $dataset->status
				]);
			}
			return response()->json(['message' => 'Berhasil dihitung']);
		} catch (QueryException $e) {
			Log::error($e);
			return response()->json(['message' => $e->errorInfo[2]], 500);
		}
	}

	/**
	 * Display the specified resource.
	 */
	public function show()
	{
		return DataTables::of(Classification::query())
			->editColumn('type', function (Classification $class) {
				return Classification::$tipedata[$class->type];
			})->make();
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Request $request)
	{
		$request->validate(Classification::$rule);
		try {
			if ($request->type === 'all')
				Classification::truncate();
			else
				Classification::where('type', $request->type)->delete();
			return response()->json(['message' => 'Berhasil direset']);
		} catch (QueryException $e) {
			Log::error($e);
			return response()->json(['message' => $e->errorInfo[2]], 500);
		}
	}
	private function getData($type)
	{
		// if($type==='all'){
		// 	$training=TrainingData::get();
		// 	$testing=TestingData::get();
		// 	$data=$training->merge($testing);
		// }else 
		if ($type === 'train') {
			if (TrainingData::count() === 0)
				return false;
			$data = TrainingData::get();
		} else {
			if (TestingData::count() === 0)
				return false;
			$data = TestingData::get();
		}
		return $data;
	}
	private function normalDistribution($x, $sd, $mean)
	{
		return (1 / ($sd * sqrt(2 * pi()))) * exp(-0.5 * pow(($x - $mean) / $sd, 2));
	}
}
