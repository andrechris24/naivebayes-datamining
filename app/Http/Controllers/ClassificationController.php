<?php

namespace App\Http\Controllers;

use App\Exports\ClassificationExport;
use App\Models\{Classification, Probability, TestingData, TrainingData};
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ClassificationController extends Controller
{
	public function export($type)
	{
		if (Classification::count() === 0)
			return back()->withError('Gagal download: Tidak ada data hasil klasifikasi');
		return Excel::download(
			new ClassificationExport($type),
			"klasifikasi_{$type}_" . time() . ".xlsx"
		);
	}
	public function index()
	{
		return view('main.naivebayes.classify', ['hasil' => ProbabLabel::$label]);
	}
	public function create(Request $request)
	{
		$request->validate(Classification::$rule);
		try {
			if (Probability::count() === 0)
				return response()->json(['message' => 'Probabilitas belum dihitung'], 400);

			//Preprocessor
			if ($request->tipe === 'test') $pre = ProbabLabel::preprocess('test');

			$semuadata = $this->getData($request->tipe); //Dataset
			if (!$semuadata) {
				return response()->json([
					'message' => 'Tipe Data yang dipilih kosong',
					'errors' => ['tipe' => 'Tipe Data yang dipilih kosong']
				], 400);
			}
			foreach ($semuadata as $dataset) {
				$klasifikasi = ProbabLabel::hitungProbab($dataset);
				Classification::updateOrCreate(
					['name' => $dataset->nama, 'type' => $request->tipe],
					[
						'true' => $klasifikasi['true'],
						'false' => $klasifikasi['false'],
						'predicted' => $klasifikasi['predict'],
						'real' => $dataset->status
					]
				);
			}
			return response()->json(
				['message' => 'Berhasil dihitung', 'preprocess' => $pre ?? 0]
			);
		} catch (QueryException $e) {
			Log::error($e);
			return response()->json(['message' => $e->errorInfo[2]], 500);
		}
	}
	public function show()
	{
		return DataTables::of(Classification::query())
			->editColumn('type', function (Classification $class) {
				return Classification::$tipedata[$class->type];
			})->editColumn('predicted', function (Classification $class) {
				return ProbabLabel::$label[$class->predicted];
			})->editColumn('real', function (Classification $class) {
				return ProbabLabel::$label[$class->real];
			})->make();
	}
	public function destroy(Request $request)
	{
		$request->validate(Classification::$rule);
		try {
			if ($request->tipe === 'all') Classification::truncate();
			else Classification::where('type', $request->tipe)->delete();
			return response()->json(['message' => 'Berhasil direset']);
		} catch (QueryException $e) {
			Log::error($e);
			return response()->json(['message' => $e->errorInfo[2]], 500);
		}
	}
	private function getData(string $type)
	{
		if ($type === 'train') {
			if (TrainingData::count() === 0) return false;
			$data = TrainingData::get();
		} else {
			if (TestingData::count() === 0) return false;
			$data = TestingData::get();
		}
		return $data;
	}
}
