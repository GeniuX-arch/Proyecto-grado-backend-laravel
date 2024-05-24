<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMateriasTable extends Migration
{
    public function up()
    {
        Schema::create('materias', function (Blueprint $table) {
            $table->int('id')->primary();
            $table->string('nombre');
            $table->float('calificacion_alumno')->nullable();
            $table->string('experiencia')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('materias');
    }
}
