<?php

namespace App\Livewire;
use App\Models\Atribut;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Str;
use Livewire\Component;

class Attribute extends Component
{
	public int $id;
	public string $name;
	public string $type;
	public string $desc;
	public function store()
	{
		try {
			$this->validate(Atribut::$rules);
			$req = [
				'name' => $this->name,
				'slug' => Str::slug($this->name, '_'),
				'type' => $this->type,
				'desc' => $this->desc];
			if ($this->id) {
				$atribut = Atribut::findOrFail($this->id);
				$this->editColumn('training_data', $atribut, $req);
				$this->editColumn('testing_data', $atribut, $req);
				$atribut->update($req);
				$this->dispatch('toast',type:'success',msg:'Berhasil diedit');
			} else {
				$this->addColumn('training_data', $req);
				$this->addColumn('testing_data', $req);
				Atribut::create($req);
				$this->dispatch('toast',type:'success',msg:'Berhasil disimpan');
			}
		} catch (QueryException $e) {
			if ($e->errorInfo[1] === 1062 || $e->errorInfo[1] === 1060) {
				$this->addError('name','Nama Atribut sudah digunakan');
				return response()->json([
					'message' => "Nama Atribut \"$request->name\" sudah digunakan"
				], 422);
			}else{
				Log::error($e);
				$this->dispatch(
					'toast',type:'error',msg:"Terjadi kesalahan database #{$e->errorInfo[1]}"
				);
			}
		}catch(ModelNotFoundException){
			$this->dispatch(
					'toast',type:'error',msg:"Gagal edit: Atribut tidak ditemukan"
				);
		}
	}
	public function edit(Atribut $atribut)
	{
		$this->id=$atribut->id;
		$this->name=$atribut->name;
		$this->type=$atribut->type;
		$this->desc=$atribut->desc;
		$this->dispatch('edit');
	}
	public function destroy(Atribut $atribut)
	{
		try {
			$this->delColumn('training_data', $atribut);
			$this->delColumn('testing_data', $atribut);
			$atribut->delete();
			$this->dispatch('toast',type:'success',msg:'Atribut berhasil dihapus');
		} catch (QueryException $e) {
			Log::error($e);
			$this->dispatch(
				'toast',type:'error',msg:"Terjadi kesalahan database #{$e->errorInfo[1]}"
			);
		}
	}
	private function addColumn(string $tabel, array $req): void
	{
		if (!Schema::hasColumn($tabel, $req['slug'])) {
			Schema::table($tabel, function (Blueprint $table) use ($req) {
				if ($req['type'] === 'numeric')
					$table->integer($req['slug'])->nullable()->after('nama');
				else {
					$table->foreignId($req['slug'])->nullable()->constrained('nilai_atributs')
						->nullOnDelete()->cascadeOnUpdate()->after('nama');
				}
			});
		}
	}
	private function editColumn(string $tabel, $attr, array $req): void
	{
		Schema::table($tabel, function (Blueprint $table) use ($attr, $req) {
			if ($attr->type !== $req['type']) {
				if ($req['type'] === 'numeric') {
					$table->dropConstrainedForeignId($attr->slug);
					$table->integer($req['slug'])->nullable()->after('nama');
				} else {
					$table->dropColumn($attr->slug);
					$table->foreignId($req['slug'])->nullable()->constrained('nilai_atributs')
						->nullOnDelete()->cascadeOnUpdate()->after('nama');
				}
			} else if ($attr->name !== $req['name']) {
				if ($attr->type === 'categorical') $table->dropForeign([$attr->slug]);
				$table->renameColumn($attr->slug, $req['slug']);
				if ($req['type'] === 'categorical') {
					$table->foreign($req['slug'])->references('id')->on('nilai_atributs')
						->nullOnDelete()->cascadeOnUpdate();
				}
			}
		});
	}
	private function delColumn(string $tabel, $attr): void
	{
		if (Schema::hasColumn($tabel, $attr->slug)) {
			Schema::table($tabel, function (Blueprint $table) use ($attr) {
				if ($attr->type === 'categorical') $table->dropForeign([$attr->slug]);
				$table->dropColumn($attr->slug);
			});
		}
	}
	public function render()
	{
		return view('livewire.attribute');
	}
}
