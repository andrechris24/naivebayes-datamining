<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Symfony\Component\Mailer\Exception\TransportException;

#[Layout('components.layouts.auth')]
class Forgot extends Component
{
	public string $email;
	public function recoverPassword()
	{
		try {
			$cred = $this->validate(User::$forgetrules);
			$status = Password::sendResetLink($cred);
			if ($status === Password::RESET_LINK_SENT)
				$this->dispatch('sent');
			elseif ($status === Password::RESET_THROTTLED)
				$this->dispatch('error', message: "Tunggu sebentar sebelum mencoba lagi.");
		} catch (QueryException $e) {
			Log::error($e);
			$this->dispatch('error', message: "Terjadi kesalahan Database #{$e->errorInfo[1]}");
		} catch (TransportException $e) {
			Log::error($e);
			$this->dispatch('error', message: "Email gagal dikirim");
		}
	}
	public function render()
	{
		return view('livewire.forgot');
	}
}
