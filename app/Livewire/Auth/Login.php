<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class Login extends Component
{
	public $email = '';
	public $password = '';
	public $remember = false;
	public function login()
	{
		try {
			$credentials = $this->validate(User::$loginrules);
			if (Auth::attempt($credentials, $this->remember)) {
				$user = User::firstWhere('email', $this->email);
				Auth::login($user, $this->remember);
				Session::regenerate();
				$this->redirectRoute('home');
			}
			$this->addError('email', trans('auth.failed'));
		} catch (QueryException $th) {
			Log::error($th);
			$this->dispatch('toast', type: 'error', message: "Gagal login: Kesalahan database #{$th->errorInfo[1]}");
		}
	}
	public function render()
	{
		return view('livewire.auth.login');
	}
}