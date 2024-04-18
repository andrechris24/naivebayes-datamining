<?php

namespace App\Livewire;

use App\Exports\TestingExport;
use App\Http\Controllers\ProbabLabel;
use App\Imports\TestingImport;
use App\Models\Atribut;
use App\Models\Classification;
use App\Models\NilaiAtribut;
use App\Models\Probability;
use App\Models\TestingData;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class DataTesting extends Component
{
	use WithFileUploads;

	#[Validate('bail', 'required', 'file', 'mimetypes:application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.oasis.opendocument.spreadsheet,text/csv,text/tab-separated-values')]
	public $dataset;
	public int $id;
	public string $nama;
	public array $q = [];
	public bool $status;
	public function export()
	{
		if (TestingData::count() === 0) {
			return $this->dispatch(
				'toast',
				type: 'error',
				msg: 'Gagal download: Data Testing kosong'
			);
		}
		return Excel::download(new TestingExport, 'testing.xlsx');
	}
	public function import()
	{
		Excel::import(new TestingImport, $this->dataset);
		$this->dispatch('toast', type: 'success', msg: 'Berhasil diupload');
	}
	public function store()
	{
		try {
			$this->validate(TestingData::$rules);
			foreach ($this->q as $id => $q) $req[$id] = $q;
			$req['nama'] = $this->nama;
			if ($this->status === 'Otomatis') {
				$hasil = ProbabLabel::hitungProbab($req);
				$req['status'] = $hasil['predict'];
			} else $req['status'] = $this->status;
			if ($this->id) {
				TestingData::updateOrCreate(['id' => $this->id], $req);
				$this->dispatch('toast', type: 'success', msg: 'Berhasil diedit');
			} else {
				TestingData::create($req);
				$this->dispatch('toast', type: 'success', msg: 'Berhasil disimpan');
			}
		} catch (QueryException $e) {
			Log::error($e);
			$this->dispatch(
				'toast',
				type: 'error',
				msg: "Terjadi kesalahan database #{$e->errorInfo[1]}"
			);
		}
	}
	public function edit(TestingData $testing)
	{
		$this->id = $testing->id;
		$this->nama = $testing->nama;
		$this->status = $testing->status;
		foreach (Atribut::get() as $attr) {
			$this->q[$attr->slug] = $testing[$attr->slug];
		}
		$this->dispatch('edit');
	}
	public function destroy(TestingData $testing)
	{
		try {
			Classification::where('name', $testing->nama)->where('type', 'test')
				->delete();
			$testing->delete();
			$this->dispatch('toast', type: 'success', msg: 'Berhasil dihapus');
		} catch (QueryException $e) {
			Log::error($e);
			$this->dispatch(
				'toast',
				type: 'error',
				msg: "Gagal hapus: Kesalahan database #{$e->errorInfo[1]}"
			);
		}
	}
	public function clear()
	{
		try {
			Classification::where('type', 'test')->delete();
			TestingData::truncate();
			$this->dispatch('toast', type: 'success', msg: 'Berhasil dihapus');
		} catch (QueryException $e) {
			Log::error($e);
			$this->dispatch(
				'toast',
				type: 'error',
				msg: "Gagal hapus: Kesalahan database #{$e->errorInfo[1]}"
			);
		}
	}
	public function render()
	{
		$atribut = Atribut::get();
		if (count($atribut) === 0) {
			return to_route('atribut.index')
				->withWarning('Tambahkan Atribut dan Nilai Atribut dulu sebelum menginput Dataset');
		}
		$nilai = NilaiAtribut::get();
		if (count($nilai) === 0) {
			return to_route('atribut.nilai.index')
				->withWarning('Tambahkan Nilai Atribut dulu sebelum menginput Dataset');
		}
		$calculated = Probability::count();
		$hasil = ProbabLabel::$label;
		return view(
			'livewire.data-testing',
			compact('atribut', 'nilai', 'calculated', 'hasil')
		);
	}
}
