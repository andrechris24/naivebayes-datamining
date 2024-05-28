<?php

namespace App\Http\Controllers;

use App\Models\Atribut;
use App\Models\NilaiAtribut;
use App\Models\TrainingData;
use App\Models\TestingData;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class AtributController extends Controller
{
	public function count()//Tampilkan jumlah atribut tidak digunakan
	{
		$unused = 0;
		foreach (Atribut::get() as $attr) {
			$nulls = TrainingData::whereNotNull($attr->slug)->count() +
				TestingData::whereNotNull($attr->slug)->count();
			if ($nulls === 0) $unused++;
		}
		return ['unused' => $unused];
	}
	/**
	 * Tampilkan halaman Atribut
	 */
	public function index()
	{
		return view('main.atribut.index');
	}

	/**
	 * DataTables: Tampilkan data Atribut
	 */
	public function create()
	{
		return DataTables::of(Atribut::query())
			->editColumn('type', function (Atribut $attr) {
				return Atribut::$tipe[$attr->type];
			})->make();
	}

	/**
	 * Simpan Atribut baru atau simpan perubahan ke database
	 */
	public function store(Request $request)
	{
		try {
			$request->validate(Atribut::$rules);
			$req = $request->all();
			$req['slug'] = Str::slug($request->name, '_');
			if (!empty($request->id)) {
				$atribut = Atribut::findOrFail($request->id);
				$this->editColumn('training_data', $atribut, $req);
				$this->editColumn('testing_data', $atribut, $req);
				$atribut->update([
					'name' => $req['name'],
					'slug' => $req['slug'],
					'type' => $req['type'],
					'desc' => $req['desc']
				]);
				if ($req['type'] === 'numeric' && $atribut->type === 'categorical')
					NilaiAtribut::where('atribut_id', $request->id)->delete();
				return response()->json(['message' => 'Berhasil diedit']);
			} else {
				$this->addColumn('training_data', $req);
				$this->addColumn('testing_data', $req);
				Atribut::create($req);
				return response()->json(['message' => 'Berhasil disimpan']);
			}
		} catch (QueryException $e) {
			if (in_array($e->errorInfo[1], [1060, 1062])) {
				return response()->json([
					'message' => "Nama Atribut \"$request->name\" sudah digunakan",
					'errors' => ['name' => "Nama Atribut sudah digunakan"]
				], 422);
			}
			Log::error($e);
			return response()->json(['message' => $e->errorInfo[2]], 500);
		}
	}

	/**
	 * Tampilkan atribut yang akan diedit
	 */
	public function edit(Atribut $atribut)
	{
		return response()->json($atribut);
	}

	/**
	 * Hapus atribut dari database
	 */
	public function destroy(Atribut $atribut)
	{
		$this->delColumn('training_data', $atribut);
		$this->delColumn('testing_data', $atribut);
		// NilaiAtribut::where('atribut_id',$atribut->id)->delete();
		$atribut->delete();
		return response()->json(['message' => "Berhasil dihapus"]);
	}
	private function addColumn(string $tabel, array $req): void
	{//Tambahkan kolom sesuai nama atribut ke tabel Dataset
		if (!Schema::hasColumn($tabel, $req['slug'])) {//Cek jika tidak ada
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
	{//Edit kolom pada tabel Dataset
		if ($attr->type !== $req['type']) {//Jika tipe atribut diubah
			Schema::table($tabel, function (Blueprint $table) use ($attr, $req) {
				if ($req['type'] === 'numeric')
					$table->dropConstrainedForeignId($attr->slug);
				else $table->dropColumn($attr->slug);
			});
			Schema::table($tabel, function (Blueprint $table) use ($req) {
				if ($req['type'] === 'numeric')
					$table->integer($req['slug'])->nullable()->after('nama');
				else {
					$table->foreignId($req['slug'])->nullable()->constrained('nilai_atributs')
						->nullOnDelete()->cascadeOnUpdate()->after('nama');
				}
			});
		} else if ($attr->name !== $req['name']) {
			Schema::table($tabel, function (Blueprint $table) use ($attr, $req) {
				$table->renameColumn($attr->slug, $req['slug']);
				if ($attr->type === 'categorical' && $req['type'] === 'categorical') {
					$table->dropForeign([$attr->slug]);
					$table->foreign($req['slug'])->references('id')->on('nilai_atributs')
						->nullOnDelete()->cascadeOnUpdate();
				}
			});
		}
	}
	private function delColumn(string $tabel, $attr): void
	{//Hapus kolom sesuai nama atribut pada tabel Dataset
		if (Schema::hasColumn($tabel, $attr->slug)) {//Cek jika ada
			Schema::table($tabel, function (Blueprint $table) use ($attr) {
				if ($attr->type === 'categorical') $table->dropForeign([$attr->slug]);
				$table->dropColumn($attr->slug);
			});
		}
	}
}
