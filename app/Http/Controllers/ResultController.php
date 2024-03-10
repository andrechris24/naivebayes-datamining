<?php

namespace App\Http\Controllers;

use App\Models\Classification;

class ResultController extends Controller
{
	public function index()
	{
		$data=[
			'll'=>Classification::where('predicted','Layak')->where('real','Layak')->count(),
			'ltl'=>Classification::where('predicted','Tidak Layak')->where('real','Layak')->count(),
			'tll'=>Classification::where('predicted','Layak')->where('real','Tidak Layak')->count(),
			'tltl'=>Classification::where('predicted','Tidak Layak')->where('real','Tidak Layak')->count()
		];
		$performa=[
			'accuracy'=>($data['ll']+$data['tltl'])/array_sum($data),
			'precision'=>0,
			'recall'=>0
		];
		return view('main.performa',compact('data','performa'));
	}
}
