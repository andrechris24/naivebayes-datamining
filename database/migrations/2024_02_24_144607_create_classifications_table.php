<?php

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
		Schema::create('classifications', function (Blueprint $table) {
			$table->id();
			$table->string('name', 99);
			$table->enum('type', ['train', 'test']);
			$table->double('layak', 25, 20)->default(0.00);
			$table->double('tidak_layak', 25, 20)->default(0.00);
			$table->enum('predicted', ['Layak', 'Tidak Layak'])
				->comment('Kelas prediksi');
			$table->enum('real', ['Layak', 'Tidak Layak'])->comment('Kelas asli');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('classifications');
	}
};
