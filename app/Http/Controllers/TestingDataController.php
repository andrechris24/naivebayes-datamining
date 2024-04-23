<?php

namespace App\Http\Controllers;

use App\Exports\TestingExport;
use App\Imports\TestingImport;
use App\Models\Atribut;
use App\Models\Classification;
use App\Models\NilaiAtribut;
use App\Models\Probability;
use App\Models\TestingData;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class TestingDataController extends Controller
{
	public function export()
	{
		if (TestingData::count() === 0)
			return back()->withError('Gagal download: Data Testing kosong');
		return Excel::download(new TestingExport, 'testing.xlsx');
	}
	public function import(Request $request)
	{
		$request->validate(TestingData::$filerule);
		Excel::import(new TestingImport, request()->file('data'));
		return response()->json(['message' => 'Berhasil diimpor']);
	}
	public function count()
	{
		$test = TestingData::get();
		$testUnique = $test->unique(['nama']);
		return [
			'total' => count($test), 'duplicate' => $test->diff($testUnique)->count()
		];
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
		$calculated = Probability::count();
		$hasil = ProbabLabel::$label;
		return view(
			'main.dataset.testing',
			compact('atribut', 'nilai', 'calculated', 'hasil')
		);
	}
	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		$dt = DataTables::of(TestingData::query());
		foreach (Atribut::get() as $attr) {
			if ($attr->type === 'categorical') {
				$dt->editColumn($attr->slug, function (TestingData $test) use ($attr) {
					$atrib = NilaiAtribut::find($test[$attr->slug]);
					return $atrib->name ?? "?";
				});
			}
		}
		$dt->editColumn('status', function (TestingData $test) {
			return ProbabLabel::$label[$test->status];
		});
		return $dt->make();
	}
	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		try {
			$request->validate(TestingData::$rules);
			foreach ($request->q as $id => $q) $req[$id] = $q;
			$req['nama'] = $request->nama;
			if ($request->status === 'auto') {
				$hasil = ProbabLabel::hitungProbab($req);
				$req['status'] = $hasil['predict'];
			} else $req['status'] = $request->status;
			if (!empty($request->id)) {
				TestingData::updateOrCreate(['id' => $request->id], $req);
				return response()->json(['message' => 'Berhasil diedit']);
			} else {
				TestingData::create($req);
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
	public function edit(TestingData $testing)
	{
		return response()->json($testing);
	}
	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(TestingData $testing)
	{
		Classification::where('name', $testing->nama)->where('type', 'test')
			->delete();
		$testing->delete();
		return response()->json(['message' => 'Berhasil dihapus']);
	}
	public function clear()
	{
		try {
			Classification::where('type', 'test')->delete();
			TestingData::truncate();
			return response()->json(['message' => 'Berhasil dihapus']);
		} catch (QueryException $e) {
			Log::error($e);
			return response()->json(['message' => $e->errorInfo[2]], 500);
		}
	}
}
