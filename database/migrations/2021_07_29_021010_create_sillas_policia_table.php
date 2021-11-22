<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSillasPoliciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::create('sillas_policia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('silla_id')->constrained();
            $table->foreignId('policia_id')->constrained();
            $table->enum('confirmacion', ['s', 'n'])->default('n');
            $table->enum('asistencia', ['s', 'n'])->default('n');
            $table->timestamps();
        });
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sillas_policia');
    }
}
