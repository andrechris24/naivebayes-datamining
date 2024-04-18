<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class Register extends Component
{
	public string $name;
	public string $email;
	public string $password;
	public string $password_confirmation;
	public function register()
	{
		try {
			$this->validate(User::$rules);
			User::create([
				'name' => $this->name,
				'email' => Str::lower($this->email),
				'password' => Hash::make($this->password)
			]);
			session()->flash('success', 'Akun sudah dibuat.');
			$this->redirectRoute('login');
		} catch (QueryException $e) {
			Log::error($e);
			$this->dispatch('error', message: "Kesalahan Database {$e->errorInfo[1]}");
		}
	}
	public function render()
	{
		return view('livewire.auth.register');
	}
}
