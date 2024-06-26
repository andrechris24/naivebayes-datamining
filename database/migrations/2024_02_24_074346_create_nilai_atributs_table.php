<?php

use App\Models\Atribut;
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
		Schema::create('nilai_atributs', function (Blueprint $table) {
			$table->id();
			$table->foreignIdFor(Atribut::class)->constrained()->cascadeOnDelete();
			$table->string('name', 99);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('nilai_atributs');
	}
};
