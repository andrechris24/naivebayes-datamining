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
			if ($request->type === 'test')
				Controller::preprocess('test');
			//Preprocessor End

			$semuadata = $this->getData($request->type); //Dataset
			if (!$semuadata) {
				return response()->json([
					'message' => 'Tipe Data yang dipilih kosong'
				], 400);
			}
			foreach ($semuadata as $dataset) {
				$klasifikasi = Controller::hitungProbab($dataset);
				Classification::updateOrCreate([
					'name' => $dataset->nama,
					'type' => $request->type
				], [
					'layak' => $klasifikasi['layak'],
					'tidak_layak' => $klasifikasi['tidak_layak'],
					'predicted' => $klasifikasi['predict'],
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
	private function getData(string $type)
	{
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
}
