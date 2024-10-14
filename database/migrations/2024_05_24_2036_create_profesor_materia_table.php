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
            $table->unsignedInteger('profesor_id');  // Cambiar a unsignedInteger
            $table->unsignedInteger('materia_id');  // Asegúrate de que también sea unsigned
            $table->unsignedInteger('experiencia');
            $table->unsignedInteger('calificacion_alumno');

            // Define las claves foráneas
            $table->foreign('profesor_id')->references('id')->on('profesores')->onDelete('cascade');
            $table->foreign('materia_id')->references('id')->on('materias')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('profesor_materia');
    }
}
