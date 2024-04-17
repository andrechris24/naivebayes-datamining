<?php

namespace App\Livewire;

use App\Exports\TrainingExport;
use App\Http\Controllers\ProbabLabel;
use App\Imports\TrainingImport;
use App\Models\Atribut;
use App\Models\Classification;
use App\Models\NilaiAtribut;
use App\Models\Probability;
use App\Models\TrainingData;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class DataTraining extends Component
{
	use WithFileUploads;

	#[Validate('bail', 'required', 'file', 'mimetypes:application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.oasis.opendocument.spreadsheet,text/csv,text/tab-separated-values')]
	public $dataset;
	public int $id;
	public string $nama;
	public array $q=[];
	public bool $status;
	public function export()
	{
		if (TrainingData::count() === 0){
			return $this->dispatch(
				'toast',type:'error',msg:'Gagal download: Data Testing kosong'
			);
		}
		return Excel::download(new TrainingExport, 'training.xlsx');
	}
	public function import()
	{
		Excel::import(new TrainingImport, $this->dataset);
			$this->dispatch('toast',type:'success',msg:'Berhasil diupload');
	}
	public function store()
	{
		try {
			$this->validate(TrainingData::$rules);
			foreach ($this->q as $id => $q) $req[$id] = $q;
			$req['nama'] = $this->nama;
			$req['status'] = $this->status;
			Probability::truncate();
			if ($this->id) {
				TrainingData::updateOrCreate(['id' => $this->id], $req);
				$this->dispatch('toast',type:'success',msg:'Berhasil diedit');
			} else {
				TrainingData::create($req);
				$this->dispatch('toast',type:'success',msg:'Berhasil disimpan');
			}
		} catch (QueryException $e) {
			Log::error($e);
			$this->dispatch(
				'toast',type:'error',msg:"Terjadi kesalahan database #{$e->errorInfo[1]}"
			);
		}
	}
	public function edit(TrainingData $training)
	{
		$this->id=$training->id;
		$this->nama=$training->nama;
		$this->status=$training->status;
		foreach (Atribut::get() as $attr) {
			$this->q[$attr->slug]=$training[$attr->slug];
		}
		$this->dispatch('edit');
	}
	public function destroy(TrainingData $training)
	{
		try {
			Classification::where('name', $training->nama)->where('type', 'train')
				->delete();
			$training->delete();
			Probability::truncate();
			$this->dispatch('toast',type:'success',msg:'Berhasil dihapus');
		} catch (QueryException $e) {
			Log::error($e);
			$this->dispatch(
				'toast',
				type:'error',msg:"Gagal hapus: Kesalahan database #{$e->errorInfo[1]}"
			);
		}
	}
	public function clear()
	{
		try {
			Classification::where('type', 'train')->delete();
			Probability::truncate();
			TrainingData::truncate();
			$this->dispatch('toast',type:'success',msg:'Berhasil dihapus');
		} catch (QueryException $e) {
			Log::error($e);
			$this->dispatch(
				'toast',
				type:'error',msg:"Gagal hapus: Kesalahan database #{$e->errorInfo[1]}"
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
		$hasil = ProbabLabel::$label;
		return view('livewire.data-training',compact('atribut','nilai','hasil'));
	}
}