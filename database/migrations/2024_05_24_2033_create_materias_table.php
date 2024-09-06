<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMateriasTable extends Migration
{
    public function up()
    {
        Schema::create('materias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->float('calificacion_alumno')->nullable();
            $table->string('experiencia')->nullable();
            $table->timestamps(); // Agregar campos de timestamp: created_at y updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('materias');
    }
}
