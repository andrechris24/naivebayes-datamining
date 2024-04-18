<?php

namespace App\Livewire;

use App\Models\Atribut;
use App\Models\NilaiAtribut;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class SubAttribute extends Component
{
	public int $id;
	public int $atribut_id;
	public string $name;
	public function store()
	{
		try {
			$this->validate(NilaiAtribut::$rules);
			if ($this->id) {
				NilaiAtribut::updateOrCreate(['id' => $this->id], [
					'name' => $this->name, 'atribut_id' => $this->atribut_id
				]);
				$this->dispatch('toast', type: 'success', msg: 'Berhasil diedit');
			} else {
				NilaiAtribut::create([
					'name' => $this->name, 'atribut_id' => $this->atribut_id
				]);
				$this->dispatch('toast', type: 'success', msg: 'Berhasil disimpan');
			}
		} catch (QueryException $th) {
			Log::error($th);
			$this->dispatch(
				'toast',
				type: 'error',
				msg: "Terjadi kesalahan database #{$th->errorInfo[1]}"
			);
		}
	}
	public function edit(NilaiAtribut $nilai)
	{
		$this->id = $nilai->id;
		$this->atribut_id = $nilai->atribut_id;
		$this->name = $nilai->name;
		$this->dispatch('edit');
	}
	public function destroy(NilaiAtribut $nilai)
	{
		try {
			$nilai->delete();
			$this->dispatch('toast', type: 'success', msg: 'Berhasil dihapus');
		} catch (QueryException $e) {
			$this->dispatch(
				'toast',
				type: 'error',
				msg: "Gagal hapus: Kesalahan database #{$e->errorInfo[1]}"
			);
		}
	}
	public function render()
	{
		$atribut = Atribut::where('type', 'categorical')->get();
		if (Atribut::count() === 0) {
			return to_route('atribut.index')
				->withWarning('Tambahkan Atribut dulu sebelum menambah nilai atribut');
		}
		return view('livewire.sub-attribute', compact('atribut'));
	}
}
