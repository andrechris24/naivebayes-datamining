<?php

namespace App\Http\Controllers;

use App\Models\Atribut;
use App\Models\NilaiAtribut;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class NilaiAtributController extends Controller
{
	public function count()
	{
		$attr = Atribut::get();
		$attribs = NilaiAtribut::get();
		$totalscr = [];
		$duplicate = 0;
		foreach ($attr as $at) {
			$subs = NilaiAtribut::where('atribut_id', $at->id)->get();
			$totalscr[] = count($subs);
			$subUnique = $subs->unique(['name']);
			$duplicate += $subs->diff($subUnique)->count();
		}
		return response()->json([
			'total' => count($attribs),
			'max' => collect($totalscr)->max() ?? 0,
			'duplicate' => $duplicate
		]);
	}
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$atribut = Atribut::where('type', 'categorical')->get();
		if (Atribut::count() === 0) {
			return to_route('atribut.index')
				->withWarning('Tambahkan Atribut dulu sebelum menambah nilai atribut');
		}
		return view('main.atribut.nilai', compact('atribut'));
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		return DataTables::of(NilaiAtribut::query())
			->editColumn('atribut_id', function (NilaiAtribut $attr) {
				return $attr->atribut->name;
			})->make();
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		try {
			$request->validate(NilaiAtribut::$rules);
			if ($request->id) {
				NilaiAtribut::updateOrCreate(['id' => $request->id],[
					'name' => $request->name, 'atribut_id' => $request->atribut_id
				]);
				return response()->json(['message' => 'Berhasil diedit']);
			} else {
				NilaiAtribut::create([
					'name' => $request->name, 'atribut_id' => $request->atribut_id
				]);
				return response()->json(['message' => 'Berhasil disimpan']);
			}
		} catch (QueryException $th) {
			Log::error($th);
			return response()->json(['message' => $th->errorInfo[2]], 500);
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(NilaiAtribut $nilai)
	{
		return response()->json($nilai);
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(NilaiAtribut $nilai)
	{
		$nilai->delete();
		return response()->json(['message' => 'Berhasil dihapus']);
	}
}
