<?php

namespace App\Http\Controllers;

use App\Models\Classification;
use App\Models\Atribut;
use App\Models\NilaiAtribut;
use App\Models\TestingData;
use App\Models\TrainingData;
use Yajra\DataTables\Facades\DataTables;

class DataTableController extends Controller
{
	public function countattr()
	{
		$attr = Atribut::count();
		$unused = 0;
		foreach (Atribut::where('type', 'categorical')->get() as $at) {
			if (NilaiAtribut::where('atribut_id', $at->id)->count() === 0)
				$unused++;
		}
		return ['total' => $attr, 'unused' => $unused];
	}
	public function countsubattr()
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
	public function counttest()
	{
		$test = TestingData::get();
		$testUnique = $test->unique(['nama']);
		return [
			'total' => count($test), 'duplicate' => $test->diff($testUnique)->count()
		];
	}
	public function counttrain()
	{
		$train = TrainingData::get();
		$trainUnique = $train->unique(['nama']);
		return [
			'total' => count($train),
			'duplicate' => $train->diff($trainUnique)->count()
		];
	}
	public function klasifikasi()
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
	public function atribut()
	{
		return DataTables::of(Atribut::query())
			->editColumn('type', function (Atribut $attr) {
				return Atribut::$tipe[$attr->type];
			})->make();
	}
	public function nilaiatribut()
	{
		return DataTables::of(
			NilaiAtribut::with('atribut')->select('nilai_atributs.*')
		)->make();
	}
	public function testingdata()
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
	public function trainingdata()
	{
		$dt = DataTables::of(TrainingData::query());
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
}
