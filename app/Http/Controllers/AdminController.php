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
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
	public function index()
	{
		$data = [
			'test' => TestingData::count(),
			'train' => TrainingData::count(),
			'total' => TestingData::count() + TrainingData::count()
		];
		return view('main.index', $data);
	}
	public function logout()
	{
		User::find(Auth::id())->update(['remember_token' => null]);
		Auth::logout();
		Session::invalidate();
		Session::regenerateToken();
		Session::flash('success', 'Anda sudah logout');
		return to_route('login');
	}
	public function edit()
	{
		return view('main.profil');
	}
	public function update(Request $request)
	{
		try {
			$request->validate([
				'name' => ['bail', 'required', 'string'],
				'email' => [
					'bail', 'required', 'email', Rule::unique('users')->ignore(Auth::id())
				], 'current_password' => ['bail', 'required', 'current_password'],
				'password' => ['nullable', 'bail', 'confirmed', 'between:8,20'],
				'password_confirmation' => 'required_with:password'
			]);
			$req = $request->all();
			if (!empty($req['password']))
				$req['password'] = Hash::make($req['password']);
			else unset($req['password']);
			$req['name'] = ucfirst($req['name']);
			$req['email'] = strtolower($req['email']);
			User::findOrFail(Auth::id())->update($req);
			return response()->json(['message' => 'Tersimpan', 'nama' => $req['name']]);
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
			Session::flash('success', "Akun sudah dihapus");
			return response()->json(['message' => 'Dihapus']);
		} catch (ModelNotFoundException) {
			return response()->json(['message' => 'Akun tidak ditemukan'], 404);
		} catch (QueryException $db) {
			Log::error($db);
			return response()->json(['message' => $db->errorInfo[2]], 500);
		}
	}
}
