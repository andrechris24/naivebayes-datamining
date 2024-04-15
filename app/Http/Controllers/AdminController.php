<?php

namespace App\Http\Controllers;

use App\Models\TestingData;
use App\Models\TrainingData;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AdminController extends Controller
{
	public function index()
	{
		$datas = [
			'test' => TestingData::count(),
			'train' => TrainingData::count(),
			'total' => TestingData::count() + TrainingData::count()
		];
		return view('main.index', compact('datas'));
	}
	public function edit()
	{
		return view('main.profil');
	}
	public function update(Request $request)
	{
		try {
			$request->validate(User::$updrules);
			$req = $request->all();
			if ($request->has('password'))
				$req['password'] = Hash::make($req['password']);
			else unset($req['password']);
			$req['name'] = ucwords($req['name']);
			$req['email'] = Str::lower($req['email']);
			User::findOrFail(Auth::id())->update($req);
			return response()->json(['message' => 'Profil sudah diupdate']);
		} catch (ModelNotFoundException) {
			return response()->json(['message' => 'Akun tidak ditemukan'], 404);
		} catch (QueryException $e) {
			if ($e->errorInfo[1] === 1062) {
				return response()->json([
					'message' => "Email $request->email sudah digunakan",
					'errors' => ['email' => "Email sudah digunakan"]
				], 422);
			}
			Log::error($e);
			return response()->json(['message' => $e->errorInfo[2]], 500);
		}
	}
	public function delete(Request $request)
	{
		try {
			$request->validate(User::$delrules);
			User::findOrFail(Auth::id())->delete();
			Auth::logout();
			Session::invalidate();
			Session::regenerateToken();
			return response()->json(['message' => 'Akun sudah dihapus']);
		} catch (ModelNotFoundException) {
			return response()->json(['message' => 'Akun tidak ditemukan'], 404);
		} catch (QueryException $db) {
			Log::error($db);
			return response()->json(['message' => $db->errorInfo[2]], 500);
		}
	}
}
