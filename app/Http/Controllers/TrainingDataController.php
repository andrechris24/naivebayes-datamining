<?php

namespace App\Http\Controllers;

use App\Exports\TrainingExport;
use App\Imports\TrainingImport;
use App\Models\Atribut;
use App\Models\Classification;
use App\Models\NilaiAtribut;
use App\Models\TrainingData;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class TrainingDataController extends Controller
{
	public function export()
	{
		if (TrainingData::count() === 0)
			return back()->withError('Gagal download: Data Training kosong');
		return Excel::download(new TrainingExport, 'training_'.time().'.xlsx');
	}
	public function import(Request $request)
	{
		$request->validate(TrainingData::$filerule);
		Excel::import(new TrainingImport, $request->file('data'));
		return response()->json(['message' => 'Berhasil diimpor']);
	}
	public function count()
	{
		$train = TrainingData::get();
		$trainUnique = $train->unique(['nama']);
		$empty = 0;
		foreach (Atribut::get() as $attr)
			$empty += TrainingData::whereNull($attr->slug)->count();
		return ['duplicate' => $train->diff($trainUnique)->count(), 'empty' => $empty];
	}
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$atribut = Atribut::get();
		if (count($atribut) === 0) {
			return to_route('atribut.index')
				->withWarning('Tambahkan Atribut dulu sebelum menginput Dataset');
		}
		$nilai = NilaiAtribut::get();
		$hasil = ProbabLabel::$label;
		return view('main.dataset.training', compact('atribut', 'nilai', 'hasil'));
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		$dt = DataTables::of(TrainingData::with('nilai_atribut')->select('training_data.*'));
		foreach (Atribut::get() as $attr) {
			if ($attr->type === 'categorical') {
				$dt->editColumn($attr->slug, function (TrainingData $train) use ($attr) {
					$atrib = NilaiAtribut::find($train[$attr->slug]);
					return $atrib->name ?? "?";
				});
			}
		}
		$dt->editColumn('status', function (TrainingData $train) {
			return ProbabLabel::$label[$train->status];
		});
		return $dt->make();
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		try {
			$request->validate(TrainingData::$rules);
			foreach ($request->q as $id => $q) $req[$id] = $q;
			$req['nama'] = ucfirst($request->nama);
			$req['status'] = $request->status;
			ProbabLabel::resetProbab();
			if (!empty($request->id)) {
				TrainingData::updateOrCreate(['id' => $request->id], $req);
				return response()->json(['message' => 'Berhasil diedit']);
			} else {
				TrainingData::create($req);
				return response()->json(['message' => 'Berhasil disimpan']);
			}
		} catch (QueryException $e) {
			Log::error($e);
			return response()->json(['message' => $e->errorInfo[2]], 500);
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(TrainingData $training)
	{
		return response()->json($training);
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(TrainingData $training)
	{
		Classification::where('name', $training->nama)->where('type', 'train')
			->delete();
		$training->delete();
		ProbabLabel::resetProbab();
		return response()->json(['message' => 'Berhasil dihapus']);
	}
	public function clear()
	{
		try {
			Classification::where('type', 'train')->delete();
			ProbabLabel::resetProbab();
			TrainingData::truncate();
			return response()->json(['message' => 'Berhasil dihapus']);
		} catch (QueryException $e) {
			return response()->json(['message' => $e->errorInfo[2]], 500);
		}
	}
}
