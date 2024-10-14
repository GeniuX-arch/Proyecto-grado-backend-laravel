<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalonesTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('salones');
        Schema::create('salones', function (Blueprint $table) {
            $table->increments('id')->primary();
            $table->string('codigo');
            $table->integer('capacidad_alumnos');
            $table->string('tipo');
            $table->timestamps(); // Agregar campos de timestamp: created_at y updated_at
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('salones');
    }
}
