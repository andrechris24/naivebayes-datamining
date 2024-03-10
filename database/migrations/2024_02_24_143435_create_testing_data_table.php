<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('testing_data', function (Blueprint $table) {
			$table->id();
			$table->string('nama', 99);
			$table->foreignId('kepemilikan_rumah')->nullable()
				->constrained('nilai_atributs')->nullOnDelete()->cascadeOnUpdate();
			$table->foreignId('pekerjaan')->nullable()->constrained('nilai_atributs')
				->nullOnDelete()->cascadeOnUpdate();
			$table->integer('penghasilan')->default(0);
			$table->foreignId('listrik')->nullable()->constrained('nilai_atributs')
				->nullOnDelete()->cascadeOnUpdate();
			$table->integer('tanggungan')->default(0);
			$table->enum('status', ['Layak', 'Tidak Layak'])->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('testing_data');
	}
};
