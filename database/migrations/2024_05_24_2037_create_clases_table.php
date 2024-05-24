<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClasesTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('clases');
        Schema::create('clases', function (Blueprint $table) {
            $table->increments('id')->primary();
            $table->string('grupo');
            $table->string('dia_semana');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->integer('materia_id');
            $table->integer('salon_id');
            $table->foreign('materia_id')->references('id')->on('materias');
            $table->foreign('salon_id')->references('id')->on('salones');
        });
    }

    public function down()
    {
        Schema::dropIfExists('clases');
    }
}
