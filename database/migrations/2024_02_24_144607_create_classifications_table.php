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
			$table->double('true')->default(0.00);
			$table->double('false')->default(0.00);
			$table->boolean('predicted')->comment('Kelas prediksi');
			$table->boolean('real')->comment('Kelas asli');
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
