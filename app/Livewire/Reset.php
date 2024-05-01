<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class Reset extends Component
{
	public string $email;
	public string $token;
	public string $password;
	public string $password_confirmation;
	public function mount()
	{
		try {
			$enctoken = DB::table('password_reset_tokens')
				->where('email', $_GET['email'])->first();
			if ($enctoken === null) {
				session()->flash('error', __('passwords.user'));
				$this->redirectRoute('password.request');
			}
			$this->email = $_GET['email'];
			$this->token = $_GET['token'];
		} catch (QueryException $e) {
			Log::error($e);
			session()->flash('error', "Terjadi kesalahan database #{$e->errorInfo[1]}");
			$this->redirectRoute('password.forget');
		}
	}
	public function resetPassword()
	{
		$data = $this->validate(User::$resetrules);
		$status = Password::reset(
			$data,
			function (User $user, string $password) {
				$user->forceFill(['password' => Hash::make($password)]);
				$user->save();
				event(new PasswordReset($user));
			}
		);
		if ($status === Password::PASSWORD_RESET) {
			session()->flash('success', __('passwords.reset'));
			$this->redirectRoute('login');
		} elseif ($status === Password::INVALID_TOKEN)
			$this->dispatch('error', message: __('passwords.token'));
		elseif ($status === Password::INVALID_USER)
			$this->dispatch('error', message: __('passwords.user'));
	}
	public function render()
	{
		return view('livewire.reset');
	}
}
