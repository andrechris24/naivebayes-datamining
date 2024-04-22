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
			$table->jsonb('true');
			$table->jsonb('false');
			$table->jsonb('total');
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
