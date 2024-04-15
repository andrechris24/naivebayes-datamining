<?php

namespace App\Livewire\Auth;

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
	public $mailSentAlert = false;
	public $error = '';
	public $email = '';
	public $rules = ['email' => 'required|email|exists:users'];

	public function recoverPassword()
	{
		try {
			$cred = $this->validate(User::$forgetrules);
			$status = Password::sendResetLink($cred);
			if ($status === Password::RESET_LINK_SENT)
				$this->mailSentAlert = true;
			elseif ($status === Password::RESET_THROTTLED)
				$this->error = __('passwords.throttled');
		} catch (QueryException $e) {
			Log::error($e);
			$this->error = "Kesalahan Database #{$e->errorInfo[1]}";
		} catch (TransportException $e) {
			Log::error($e);
			$this->error = "Email gagal dikirim";
		}
	}
	public function render()
	{
		return view('livewire.auth.forgot');
	}
}
