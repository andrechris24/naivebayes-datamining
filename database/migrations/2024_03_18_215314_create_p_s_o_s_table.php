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
        Schema::create('p_s_o_s', function (Blueprint $table) {
            $table->id();
            $table->string('atribut');
            $table->integer('loop');
            $table->float('data', 25, 10);
            $table->float('function', 25, 10);
            $table->float('velocity', 25, 10);
            $table->float('pbest', 25, 10);
            $table->integer('gbest');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('p_s_o_s');
    }
};
