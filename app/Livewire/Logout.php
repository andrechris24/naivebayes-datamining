<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Logout extends Component
{
	public function logout()
	{
		User::find(Auth::id())->update(['remember_token' => null]);
		Auth::logout();
		Session::invalidate();
		Session::regenerateToken();
		Session::flash('success', 'Anda sudah logout');
		$this->redirectRoute('login');
	}
	public function render()
	{
		return view('livewire.logout');
	}
}
