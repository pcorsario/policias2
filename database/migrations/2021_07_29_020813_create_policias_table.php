<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePoliciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::create('policias', function (Blueprint $table) {
            $table->id();
            $table->string('cedula', 15);
            $table->string('apellido_paterno', 25);
            $table->string('apellido_materno', 25)->nullable();
            $table->string('nombres', 30);
            $table->string('celular', 15)->nullable();
            $table->string('convencional', 15)->nullable();
            $table->string('correo', 50)->nullable();
            $table->string('direccion_domicilio', 150)->nullable();
            $table->enum('estado', ['a', 'i'])->default('a');
            $table->foreignId('rango_id')->constrained();
            $table->foreignId('user_id')->constrained();
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
        Schema::dropIfExists('policias');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
