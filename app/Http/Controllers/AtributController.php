<?php

namespace App\Http\Controllers;

use App\Models\Atribut;
use App\Models\NilaiAtribut;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class AtributController extends Controller
{
	public function count()
	{
		$attr = Atribut::get();
		$unused = 0;
		foreach (Atribut::where('type', 'categorical')->get() as $at) {
			if (NilaiAtribut::where('atribut_id', $at->id)->count() === 0)
				$unused++;
		}
		return ['total' => count($attr), 'unused' => $unused];
	}
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		return view('main.atribut.index');
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		return DataTables::of(Atribut::query())
			->editColumn('type', function (Atribut $attr) {
				return Atribut::$tipe[$attr->type];
			})->make();
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		try {
			$req = $request->all();
			$req['slug'] = Str::slug($request->name, '_');
			if ($request->id) {
				$request->validate(Atribut::$updrules);
				$atribut = Atribut::findOrFail($request->id);
				if ($atribut->name !== $req['name']) {
					Schema::table('training_data', function (Blueprint $table) use ($req, $atribut) {
						$table->renameColumn($atribut->slug, $req['slug']);
					});
					Schema::table('testing_data', function (Blueprint $table) use ($req, $atribut) {
						$table->renameColumn($atribut->slug, $req['slug']);
					});
				}
				$atribut->update([
					'name' => $req['name'],
					'slug' => $req['slug'],
					'desc' => $req['desc']
				]);
				return response()->json(['message' => 'Berhasil diupdate']);
			} else {
				$request->validate(Atribut::$rules);
				if (!Schema::hasColumn('training_data', $req['slug'])) {
					Schema::table('training_data', function (Blueprint $table) use ($req) {
						$this->addColumn($table, $req);
					});
				}
				if (!Schema::hasColumn('testing_data', $req['slug'])) {
					Schema::table('testing_data', function (Blueprint $table) use ($req) {
						$this->addColumn($table, $req);
					});
				}
				Atribut::create($req);
				return response()->json(['message' => 'Berhasil diinput']);
			}
		} catch (QueryException $e) {
			if ($e->errorInfo[1] === 1062 || $e->errorInfo[1] === 1060) {
				return response()->json([
					'message' => "Nama Atribut \"$request->name\" sudah digunakan",
					'errors' => ['name' => 'Nama Atribut sudah digunakan']
				], 422);
			}
			Log::error($e);
			return response()->json(['message' => $e->errorInfo[2]], 500);
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Atribut $atribut)
	{
		return response()->json($atribut);
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Atribut $atribut)
	{
		if (Schema::hasColumn('training_data', $atribut->slug)) {
			Schema::table('training_data', function (Blueprint $table) use ($atribut) {
				$this->delColumn($table, $atribut);
			});
		}
		if (Schema::hasColumn('testing_data', $atribut->slug)) {
			Schema::table("testing_data", function (Blueprint $table) use ($atribut) {
				$this->delColumn($table, $atribut);
			});
		}
		$atribut->delete();
		return response()->json(['message' => "Berhasil dihapus"]);
	}
	private function addColumn($tabel, $req): void
	{
		if ($req['type'] === 'numeric')
			$tabel->integer($req['slug'])->nullable()->after('nama');
		else {
			$tabel->foreignId($req['slug'])->nullable()->constrained('nilai_atributs')
				->nullOnDelete()->cascadeOnUpdate()->after('nama');
		}
	}
	private function delColumn($tabel, $attr): void
	{
		if ($attr->type === 'categorical')
			$tabel->dropForeign([$attr->slug]);
		$tabel->dropColumn($attr->slug);
	}
}
