<?php

use App\Models\Atribut;
use App\Models\NilaiAtribut;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('probabilities', function (Blueprint $table) {
			$table->id();
			$table->foreignIdFor(Atribut::class)->cascadeOnDelete();
			$table->foreignIdFor(NilaiAtribut::class)->nullable()
				->cascadeOnDelete()->comment('Kategorikal saja');
			$table->double('layak', 25, 20)->comment('Kategorikal saja')->default(0.00);
			$table->double('tidak_layak', 25, 20)->comment('Kategorikal saja')
				->default(0.00);
			$table->double('total', 25, 20)->comment('Total Probabilitas (Kategorikal)')
				->default(0.00);
			$table->double('mean_layak', 35, 15)->default(0.00)->comment('Numerik saja');
			$table->double('mean_tidak_layak', 35, 15)->default(0.00)
				->comment('Numerik saja');
			$table->double('mean_total', 35, 15)->default(0.00)
				->comment('Rata-rata Probabilitas Numerik');
			$table->double('sd_layak', 35, 15)->default(0.00)->comment('Numerik saja');
			$table->double('sd_tidak_layak', 35, 15)->default(0.00)
				->comment('Numerik saja');
			$table->double('sd_total', 35, 15)->default(0.00)
				->comment('Simpangan baku Probabilias Numerik');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('probabilities');
	}
};
