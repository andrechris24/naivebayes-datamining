<?php

namespace App\Http\Controllers;

use App\Models\Atribut;
use App\Models\PSO;
use App\Models\TrainingData;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class PSOController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$atribut = Atribut::get();
		return view('main.pso.index', compact('atribut'));
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		return DataTables::of(PSO::query())->make();
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		$request->validate(PSO::$rules);
		try {
			$datas = TrainingData::get();
			$atrib = [];
			foreach ($datas as $train) {
				array_push($atrib, $train[$request->atribut]);
			}
			$data = array_map('intval', $atrib);
			$jml = count($datas);
			$velocity = array_fill(0, $jml, 0);
			$pbest = $data;
			$gbest = Controller::getGbest($data);
			for ($a = 0; $a < $request->loop; $a++) {
				$r1 = rand(0, 10) / 10;
				$r2 = rand(0, 10) / 10;
				foreach ($data as $key => $value) {
					$func = Controller::fungsi_tujuan($value);
					if ($func < Controller::fungsi_tujuan($pbest[$key]))
						$pbest[$key] = $value;
					if ($func < Controller::fungsi_tujuan($gbest))
						$gbest = $value;
					$velocity[$a + 1] = $a + 1 * $r1 * ($pbest[$key] - $value) + 1 * $r2 * ($gbest - $value);
					$data[$key] += $velocity[$a + 1];
					$hasil = [
						'atribut' => $request->atribut,
						'loop' => $a + 1,
						'data' => $data[$key],
						'velocity' => $velocity[$a + 1],
						'function' => $func,
						'pbest' => $pbest[$key],
						'gbest' => $gbest
					];
					PSO::create($hasil);
				}
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
	public function show(PSO $pso)
	{
		return response()->json($pso);
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(PSO $pso)
	{
		return response()->json($pso);
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, PSO $pso)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Request $req)
	{
		try {
			if ($req->atribut === "all")
				PSO::truncate();
			else
				PSO::where('atribut', $req->atribut)->delete();
			return response()->json(['message' => "Berhasil direset"]);
		} catch (QueryException $e) {
			Log::error($e);
			return response()->json(['message' => $e->errorInfo[2]], 500);
		}
	}
}
