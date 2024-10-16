<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMateriasTable extends Migration
{
    public function up()
    {
        Schema::create('materias', function (Blueprint $table) {
            $table->increments('id')->primary();
            $table->string('codigo');
            $table->string('nombre');
            $table->integer('alumnos');
            $table->integer('bloques');

            
            
            $table->timestamps(); // Agregar campos de timestamp: created_at y updated_at
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('materias');
    }
}
