<?php

namespace App\Http\Controllers;

use App\Models\Classification;
use App\Models\Atribut;
use App\Models\Probability;
use App\Models\TestingData;
use App\Models\TrainingData;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
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

			//Prior start
			if($request->type==='train'){
				if(TrainingData::count()===0)
					return response()->json(['message' => "Data Training kosong"], 400);
				$semuadata=TrainingData::get();
			}else{
				if (TestingData::count() === 0) 
					return response()->json(['message' => "Data Testing kosong"], 400);
				$semuadata=TestingData::get();
			}
			$probab = Controller::probabKelas();
			//Prior end

			foreach ($semuadata as $dataset) {
				//Posterior Start
				$plf['l'] = $plf['tl'] = 1;
				foreach (Atribut::get() as $at) {
					if ($at->type === 'categorical') {
						$probabilitas = Probability::where('nilai_atribut_id', $dataset[$at->slug])
						->first();
						$plf['l'] *= $probabilitas['layak'];
						$plf['tl'] *= $probabilitas['tidak_layak'];
					} else {
						$probabilitas = Probability::where('atribut_id', $at->id)->first();
						// dd($test[$at->slug]);
						$plf['l'] = pow(
							(1 / ($probabilitas->sd_layak * sqrt(2 * pi()))) * exp(1),
							-((pow($dataset[$at->slug] - $probabilitas->mean_layak,2)) / 
								(2 * pow($probabilitas->sd_layak,2)))
						);
						$plf['tl'] = pow(
							(1 / ($probabilitas->sd_tidak_layak * sqrt(2 * pi()))) * exp(1),
							-((pow($dataset[$at->slug] - $probabilitas->mean_tidak_layak,2)) / 
								(2 * pow($probabilitas->sd_tidak_layak,2)))
						);
					}
				}
				$p['layak'] = $plf['l'] == 0 ? 0 : ($plf['l'] * $probab['l']) / $plf['l'];
				$p['tidak_layak'] = $plf['tl'] == 0 ? 0 : ($plf['tl'] * $probab['tl']) / $plf['tl'];
				//Posterior End

				$predict = $p['layak'] >= $p['tidak_layak'] ? 'Layak' : "Tidak Layak";
				Classification::updateOrCreate([
					'name' => $dataset->nama,
					'type'=>$request->type
				],[
					'layak' => $p['layak'],
					'tidak_layak' => $p['tidak_layak'],
					'predicted' => $predict,
					'real' => $dataset->status
				]);
			}
			return response()->json(['message' => 'Berhasil dihitung']);
		} catch (QueryException $e) {
			return response()->json(['message' => $e->errorInfo[2]], 500);
		}
	}

	/**
	 * Display the specified resource.
	 */
	public function show()
	{
		return DataTables::of(Classification::query())
		->editColumn('type',function (Classification $class){
			return Classification::$tipedata[$class->type];
		})->make();
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy()
	{
		try {
			Classification::truncate();
			return response()->json(['message' => 'Berhasil direset']);
		} catch (QueryException $e) {
			return response()->json(['message' => $e->errorInfo[2]], 500);
		}
	}
}
