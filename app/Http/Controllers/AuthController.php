<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Symfony\Component\Mailer\Exception\TransportException;

class AuthController extends Controller
{
	public function register()
	{
		if (Auth::viaRemember() || Auth::check()) return to_route('home');
		return view('auth.register');
	}
	public function postRegister(Request $request)
	{
		try {
			$request->validate(User::$rules);
			$req = $request->all();
			$req['password'] = Hash::make($req['password']);
			$req['name'] = ucfirst($req['name']);
			$req['email'] = strtolower($req['email']);
			User::create($req);
			return to_route('login')->withSuccess('Akun berhasil dibuat');
		} catch (QueryException $e) {
			Log::error($e);
			return back()->withInput()->withError('Gagal membuat akun:')
				->withErrors($e->errorInfo);
		}
	}
	public function login()
	{
		if (Auth::viaRemember() || Auth::check()) return to_route('home');
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
	public function forget()
	{
		if (Auth::viaRemember() || Auth::check()) return to_route('home');
		return view('auth.forget');
	}
	public function forgetLink(Request $request)
	{
		try {
			$request->validate(User::$forgetrules);
			$status = Password::sendResetLink($request->only('email'));
			if ($status === Password::RESET_LINK_SENT)
				return back()->withSuccess("Link reset password sudah dikirim");
			elseif ($status === Password::RESET_THROTTLED) {
				return back()->withInput()
					->withError("Tunggu beberapa saat sebeelum mencoba lagi.");
			}
		} catch (TransportException $err) {
			Log::error($err);
			return back()->withInput()
				->withError("Gagal mengirim link reset password:")->withErrors($err);
		} catch (QueryException $sql) {
			Log::error($sql);
			return back()->withInput()->withErrors($sql->errorInfo)
				->withError("Gagal membuat token reset password:");
		}
		return back()
			->withError('Gagal membuat token reset password: Kesalahan tidak diketahui');
	}
	public function showReset()
	{
		if (Auth::viaRemember() || Auth::check()) return to_route('home');
		try {
			$enctoken = DB::table('password_reset_tokens')
				->where('email', $_GET['email'])->first();
			if ($enctoken === null)
				return to_route('password.forget')->withError("Pengguna tidak ditemukan");
			return view(
				'auth.reset',
				['token' => $_GET['token'], 'email' => $_GET['email']]
			);
		} catch (QueryException $e) {
			Log::error($e);
			return to_route('password.forget')->withErrors($e->errorInfo)
				->withError("Gagal memuat halaman reset password:");
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
				return to_route('login')->withSuccess("Password Anda sudah direset");
			elseif ($status === Password::INVALID_TOKEN)
				return back()->withError("Token reset password tidak valid");
			elseif ($status === Password::INVALID_USER)
				return back()->withError("Pengguna tidak ditemukan");
			return back()->withError('Reset password gagal: Kesalahan tidak diketahui');
		} catch (QueryException $e) {
			Log::error($e);
			return back()->withError("Reset password gagal:")
				->withErrors($e->errorInfo);
		}
	}
}
