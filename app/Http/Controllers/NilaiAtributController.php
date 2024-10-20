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
	{ //Tampilkan jumlah duplikat dan terbanyak
		$attr = Atribut::get();
		$totalscr = [];
		$duplicate = 0;
		foreach ($attr as $at) {
			$subs = NilaiAtribut::where('atribut_id', $at->id)->get();
			$totalscr[] = count($subs);
			$subUnique = $subs->unique(['name']);
			$duplicate += $subs->diff($subUnique)->count();
		}
		return response()->json([
			'max' => collect($totalscr)->max() ?? 0,
			'duplicate' => $duplicate
		]);
	}
	/**
	 * Tampilkan halaman Nilai Atribut
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
	 * DataTables: Tampilkan data Nilai Atribut
	 */
	public function create()
	{
		return DataTables::of(
			NilaiAtribut::with('atribut')->select('nilai_atributs.*')
		)->make();
	}

	/**
	 * Simpan data Nilai Atribut baru dan simpan perubahan
	 */
	public function store(Request $request)
	{
		try {
			$request->validate(NilaiAtribut::$rules);
			if (!empty($request->id)) {
				NilaiAtribut::updateOrCreate(
					['id' => $request->id],
					['name' => $request->name, 'atribut_id' => $request->atribut_id]
				);
				return response()->json(['message' => 'Berhasil diedit']);
			} else {
				NilaiAtribut::create([
					'name' => $request->name,
					'atribut_id' => $request->atribut_id
				]);
				return response()->json(['message' => 'Berhasil disimpan']);
			}
		} catch (QueryException $th) {
			Log::error($th);
			return response()->json(['message' => $th->errorInfo[2]], 500);
		}
	}

	/**
	 * Ambil data Nilai Atribut untuk diedit
	 */
	public function edit(NilaiAtribut $nilai)
	{
		return response()->json($nilai);
	}

	/**
	 * Hapus data Nilai Atribut
	 */
	public function destroy(NilaiAtribut $nilai)
	{
		$nilai->delete();
		return response()->json(['message' => 'Berhasil dihapus']);
	}
}
