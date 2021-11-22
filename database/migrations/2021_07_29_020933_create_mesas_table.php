<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMesasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::create('mesas', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion', 45)->nullable();
            $table->enum('estado', ['a', 'i'])->default('a');
            $table->foreignId('cuadrante_id')->constrained();
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('mesas');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
