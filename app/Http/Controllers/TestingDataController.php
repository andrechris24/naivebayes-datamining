<?php

namespace App\Http\Controllers;

use App\{Exports\TestingExport, Imports\TestingImport};
use App\Models\{Atribut, Classification, NilaiAtribut, Probability, TestingData};
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
		return Excel::download(new TestingExport, 'testing_' . time() . '.xlsx');
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
		$empty = 0;
		foreach (Atribut::get() as $attr)
			$empty += TestingData::whereNull($attr->slug)->count();
		return ['duplicate' => $test->diff($testUnique)->count(), 'empty' => $empty];
	}
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
	public function create()
	{
		$dt = DataTables::of(TestingData::with('nilai_atribut')->select('testing_data.*'));
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
	public function store(Request $request)
	{
		try {
			$request->validate(TestingData::$rules);
			foreach ($request->q as $id => $q) $req[$id] = $q;
			$req['nama'] = ucfirst($request->nama);
			if ($request->status === 'auto') {
				if (Probability::count() === 0) {
					return response()->json([
						'message' => "Probabilitas belum dihitung"
					], 400);
				}
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
	public function edit(TestingData $testing)
	{
		return response()->json($testing);
	}
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
