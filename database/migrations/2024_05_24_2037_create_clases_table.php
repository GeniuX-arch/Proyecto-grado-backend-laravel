<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClasesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
        {
        Schema::create('clases', function (Blueprint $table) {
            $table->increments('id'); // Clave primaria
            $table->string('grupo');
            $table->string('dia_semana');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->integer('alumnos');

            // Claves foráneas
            $table->unsignedInteger('materia_id');
            $table->unsignedInteger('salon_id')->nullable(); // Añadir el campo para la clave foránea
            $table->unsignedInteger('profesor_id')->nullable(); // Añadir el campo para la clave foránea

            // Definición de relaciones
            $table->foreign('materia_id')->references('id')->on('materias');
            $table->foreign('salon_id')->references('id')->on('salones');
            $table->foreign('profesor_id')->references('id')->on('profesores');

            $table->timestamps();
            $table->softDeletes(); // Para el borrado lógico
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clases');
    }
    }