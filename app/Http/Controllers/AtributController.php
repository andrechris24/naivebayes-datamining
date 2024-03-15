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
		foreach (Atribut::where('type','categorical') as $at) {
			if (NilaiAtribut::where('atribut_id', $at->id)->count() === 0)
				$unused++;
		}
		return [
			'total' => count($attr),
			'unused' => $unused
		];
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
			$request->validate(Atribut::$rules);
			$colslug = Str::slug($request->name, '_');
			if ($request->id) {
				$atribut = Atribut::findOrFail($request->id);
				if ($request->name !== $atribut->name) {
					$oldslug = $atribut->slug;
					Schema::table('training_data', function (Blueprint $table) use ($colslug, $oldslug) {
						$table->renameColumn($oldslug, $colslug);
					});
					Schema::table('testing_data', function (Blueprint $table) use ($colslug, $oldslug) {
						$table->renameColumn($oldslug, $colslug);
					});
				}
				$atribut->update([
					'name' => $request->name,
					'slug' => $colslug,
					'type' => $request->type,
					'desc' => $request->desc
				]);
				return response()->json(['message' => 'Berhasil diupdate']);
			} else {
				$req = $request->all();
				$req['slug'] = $colslug;
				if (!Schema::hasColumn('training_data', $colslug)) {
					Schema::table('training_data', function (Blueprint $table) use ($req) {
						if ($req['type'] === 'numeric')
							$table->integer($req['slug'])->default(0)->after('nama');
						else {
							$table->foreignId($req['slug'])->constrained('nilai_atributs')
							->nullOnDelete()->cascadeOnUpdate()->nullable()->after('nama');
						}
					});
				}
				if (!Schema::hasColumn('testing_data', $colslug)) {
					Schema::table('testing_data', function (Blueprint $table) use ($req) {
						if ($req['type'] === 'numeric')
							$table->integer($req['slug'])->default(0)->after('nama');
						else {
							$table->foreignId($req['slug'])->constrained('nilai_atributs')
								->nullOnDelete()->cascadeOnUpdate()->nullable()->after('nama');
						}
					});
				}
				Atribut::create($req);
				return response()->json(['message' => 'Berhasil diinput']);
			}
		} catch (QueryException $e) {
			if ($e->errorInfo[1] === 1062) {
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
				if ($atribut->type !== 'numeric')
					$table->dropForeign([$atribut->slug]);
				$table->dropColumn($atribut->slug);
			});
		}
		if (Schema::hasColumn('testing_data', $atribut->slug)) {
			Schema::table("testing_data", function (Blueprint $table) use ($atribut) {
				if ($atribut->type !== 'numeric')
					$table->dropForeign([$atribut->slug]);
				$table->dropColumn($atribut->slug);
			});
		}
		$atribut->delete();
		return response()->json(['message' => "Berhasil dihapus"]);
	}
}
