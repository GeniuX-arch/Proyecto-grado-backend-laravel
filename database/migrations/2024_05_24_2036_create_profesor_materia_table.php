<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfesorMateriaTable extends Migration
{
    public function up()
    {

        Schema::dropIfExists('profesor_materia');
        Schema::create('profesor_materia', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profesor_id');  // Asumiendo que cedula es integer
            $table->unsignedBigInteger('materia_id');  // Cambiar a unsignedBigInteger para coincidir con la tabla materias
            $table->foreign('profesor_id')->references('cedula')->on('profesores');
            $table->foreign('materia_id')->references('id')->on('materias');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('profesor_materia');
    }
}
