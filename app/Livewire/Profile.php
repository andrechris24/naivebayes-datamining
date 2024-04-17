<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Livewire\Component;

class Profile extends Component
{
	public string $name = '';
	public string $email = '';
	public string $current_password = '';
	public string $password = '';
	public string $password_confirmation = '';
	public string $confirm_pass = '';
	public function mount()
	{
		$this->name = Auth::user()->name;
		$this->email = Auth::user()->email;
	}
	public function update()
	{
		try {
			$this->validate(User::$updrules);
			if (empty($this->password))
				$data = ['name' => $this->name, 'email' => Str::lower($this->email)];
			else {
				$data = [
					'name' => $this->name,
					'email' => Str::lower($this->email),
					'password' => Hash::make($this->password)
				];
			}
			User::findOrFail(Auth::id())->update($data);
			$this->dispatch('toast', message: "Tersimpan", tipe: 'success');
		} catch (ModelNotFoundException) {
			$this->dispatch(
				'toast',
				message: "Gagal simpan: Akun tidak ditemukan",
				tipe: 'error'
			);
		} catch (QueryException $e) {
			if ($e->errorInfo[1] === 1062)
				$this->addError('email', 'Email sudah digunakan');
			else {
				Log::error($e);
				$this->dispatch(
					'toast',
					message: "Gagal simpan: Kesalahan database #{$e->errorInfo[1]}",
					tipe: 'error'
				);
			}
		}
	}
	public function delete()
	{
		try {
			$this->validate(User::$delrules);
			User::findOrFail(Auth::id())->delete();
			Auth::logout();
			Session::invalidate();
			Session::regenerateToken();
			session()->flash('success', 'Akun sudah dihapus');
			$this->redirectoute('login');
		} catch (ModelNotFoundException) {
			$this->addError('confirm_pass', 'Gagal hapus: Akun tidak ditemukan');
		} catch (QueryException $db) {
			Log::error($db);
			$this->addError(
				'confirm_pass',
				"Gagal hapus: Kesalahan database #{$db->errorInfo[1]}"
			);
		}
	}
	public function render()
	{
		return view('livewire.profile');
	}
}
