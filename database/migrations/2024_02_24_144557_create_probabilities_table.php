<?php
use App\Models\Atribut;
use App\Models\NilaiAtribut;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('probabilities', function (Blueprint $table) {
			$table->id();
			$table->foreignIdFor(Atribut::class)->cascadeOnDelete();
			$table->foreignIdFor(NilaiAtribut::class)->nullable()
				->nullOnDelete()->comment('Kategorikal saja');
			$table->double('layak', 33, 15)->comment('Kategorikal saja')
				->default(0.00000);
			$table->double('tidak_layak', 33, 15)->comment('Kategorikal saja')
				->default(0.00000);
			$table->double('mean_layak', 33, 15)->default(0.00000)
				->comment('Numerik saja');
			$table->double('mean_tidak_layak', 33, 15)->default(0.00000)
				->comment('Numerik saja');
			$table->double('sd_layak', 33, 15)->default(0.00000)
				->comment('Numerik saja');
			$table->double('sd_tidak_layak', 33, 15)->default(0.00000)
				->comment('Numerik saja');
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
