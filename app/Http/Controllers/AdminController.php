<?php

namespace App\Http\Controllers;

use App\Models\TestingData;
use App\Models\TrainingData;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Symfony\Component\Mailer\Exception\TransportException;

class AdminController extends Controller
{
	public function index()
	{
		$datas = [
			'test' => TestingData::count(),
			'train' => TrainingData::count()
		];
		return view('main.index', compact('datas'));
	}
	public function register()
	{
		if (Auth::viaRemember() || Auth::check())
			return to_route('home');
		return view('auth.register');
	}
	public function postRegister(Request $request)
	{
		try {
			$request->validate(User::$rules);
			$req = $request->all();
			$req['password'] = Hash::make($request->password);
			$req['name'] = ucwords($request->name);
			$req['email'] = Str::lower($request->email);
			User::create($req);
			return to_route('login')->withSuccess('Akun berhasil dibuat');
		} catch (QueryException $e) {
			return back()->withInput()->withError('Gagal membuat akun:')
				->withErrors($e->errorInfo);
		}
	}
	public function login()
	{
		if (Auth::viaRemember() || Auth::check())
			return to_route('home');
		return view('auth.login');
	}
	public function postLogin(Request $request)
	{
		$credentials = $request->validate(User::$loginrules);
		if (Auth::attempt($credentials, $request->get('remember'))) {
			$user = User::firstWhere('email', $request->email);
			Auth::login($user, $request->get('remember'));
			Session::regenerate();
			return to_route('home');
		}
		return back()->onlyInput('email')->withError('E-mail atau Password salah');
	}
	public function logout()
	{
		User::find(Auth::id())->update(['remember_token' => null]);
		Auth::logout();
		Session::invalidate();
		Session::regenerateToken();
		return redirect('login')->withSuccess('Anda sudah logout');
	}
	public function forget()
	{
		if (Auth::viaRemember() || Auth::check())
			return to_route('home');
		return view('auth.forget');
	}
	public function forgetLink(Request $request)
	{
		try {
			$request->validate(User::$forgetrules);
			$status = Password::sendResetLink($request->only('email'));
			if ($status === Password::RESET_LINK_SENT)
				return back()->withSuccess(__('passwords.sent'));
			elseif ($status === Password::RESET_THROTTLED)
				return back()->withInput()->withError(__('passwords.throttled'));
		} catch (TransportException $err) {
			// DB::table('password_reset_tokens')->where('email',$request->email)->delete();
			return back()->withInput()->withError("Gagal mengirim link reset password:")
				->withErrors($err);
		} catch (QueryException $sql) {
			return back()->withInput()->withErrors($sql->errorInfo)
				->withError("Gagal membuat token reset password:");
		}
		return back()
			->withError('Gagal membuat token reset password: Kesalahan tidak diketahui');
	}
	public function showReset()
	{
		if (Auth::viaRemember() || Auth::check())
			return to_route('admin.home');
		try {
			$enctoken = DB::table('password_reset_tokens')
				->where('email', $_GET['email'])->first();
			if ($enctoken === null)
				return to_route('password.request')->withError(__('passwords.user'));
			if (!Hash::check($_GET['token'], $enctoken->token))
				return to_route('password.request')->withError(__('passwords.token'));
			return view('auth.reset', ['token' => $_GET['token'], 'email' => $_GET['email']]);
		} catch (QueryException $e) {
			return to_route('password.request')->withError("Kesalahan:")
				->withErrors($e->errorInfo);
		}
	}
	public function reset(Request $request)
	{
		$request->validate(User::$resetrules);
		try {
			$status = Password::reset(
				$request->only('email', 'password', 'password_confirmation', 'token'),
				function (User $user, string $password) {
					$user->forceFill(['password' => Hash::make($password)]);
					$user->save();
					event(new PasswordReset($user));
				}
			);
			if ($status === Password::PASSWORD_RESET)
				return to_route('login')->withSuccess(__('passwords.reset'));
			elseif ($status === Password::INVALID_TOKEN)
				return back()->withError(__('passwords.token'));
			elseif ($status === Password::INVALID_USER)
				return back()->withError(__('passwords.user'));
			return back()->withError('Reset password gagal: Kesalahan tidak diketahui');
		} catch (QueryException $e) {
			return back()->withError("Reset password gagal:")
				->withErrors($e->errorInfo);
		}
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
				$req['password'] = Hash::make($request->password);
			else
				unset($req['password']);
			$req['name'] = ucwords($request->name);
			$req['email'] = Str::lower($request->email);
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
			return response()->json(['message' => $db->errorInfo[2]], 500);
		}
	}
}
