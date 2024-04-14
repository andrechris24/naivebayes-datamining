<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth')] 
class Register extends Component
{
	public $name='';
	public $email = '';
	public $password = '';
	public $password_confirmation = '';
	public $error='';
	public $created=false;
	public function register()
	{
		try {
			$this->validate(User::$rules);
			$user = User::create([
				'name'=>$this->name,
				'email' =>Str::lower($this->email),
				'password' => Hash::make($this->password)
			]);
			$this->created=true;
			session()->flash('success', 'Akun sudah dibuat.');
			$this->redirectRoute('login');
		} catch (QueryException $e) {
			Log::error($e);
			$this->error="Kesalahan Database {$e->errorInfo[1]}";
		}
	}
	public function render()
	{
		return view('livewire.auth.register');
	}
}
