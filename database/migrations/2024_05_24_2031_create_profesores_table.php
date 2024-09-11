<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfesoresTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('profesores');
        Schema::create('profesores', function (Blueprint $table) {
            $table->integer('cedula')->primary();
            $table->string('nombre');
            $table->string('tipo_contrato');
            $table->string('estado');
            $table->timestamps(); // Agregar campos de timestamp: created_at y updated_at
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('profesores');
    }
}