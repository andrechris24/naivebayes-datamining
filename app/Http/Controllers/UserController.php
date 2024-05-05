<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		return view('main.user');
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		return DataTables::of(User::query())->make();
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		try {
			$req = $request->all();
			$req['name'] = ucfirst($req['name']);
			$req['email'] = strtolower($req['email']);
			if (!empty($request->id)) { // update the value
				if (Auth::id() === $request->id) {
					return response()->json([
						'message' => "Ini akun Anda. Gunakan halaman Profil untuk mengedit akun."
					], 400);
				}
				$request->validate([
					'name' => ['bail', 'required', 'string'],
					'email' => [
						'bail',
						'required',
						'email',
						Rule::unique('users')->ignore($request->id)
					], 'current_password' => ['bail', 'required', 'current_password'],
					'password' => ['nullable', 'bail', 'confirmed', 'between:8,20'],
					'password_confirmation' => 'required_with:password'
				]);
				if (empty($req['password'])) {
					unset($req['password']);
					unset($req['password_confirmation']);
				} else $req['password'] = Hash::make($req['password']);
				$users = User::findOrFail($request->id);
				$users->update($req);
				return response()->json(["message" => 'Berhasil diupdate']);
			} else {
				$request->validate(User::$userrules);
				$req['password'] = Hash::make($req['password']);
				// $req['email_verified_at'] = Carbon::now()->timestamp;
				$users = User::create($req);
				return response()->json(["message" => 'Berhasil dibuat']);
			}
		} catch (QueryException $th) {
			Log::error($th);
			return response()->json(['message' => $th->errorInfo[2]]);
		} catch (ModelNotFoundException) {
			return response()->json(['message' => 'Pengguna tidak ditemukan'], 404);
		}
	}

	/**
	 * Display the specified resource.
	 */
	public function show(User $user)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(User $user)
	{
		if ($user === Auth::user())
			return response()->json(['message' => "Ini akun Anda"], 302);
		return response()->json($user);
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Request $req, User $user)
	{
		$req->validate(User::$delrules);
		if (Auth::user() === $user) {
			return response()->json([
				'message' => 'Ini akun Anda. Hapus akun melalui halaman Edit Profil.'
			], 400);
		}
		$user->delete();
		return response()->json(['message' => "Berhasil dihapus"]);
	}
}
