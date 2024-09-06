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
            $table->unsignedBigInteger('materia_id'); // Cambiar a unsignedBigInteger
            $table->unsignedInteger('salon_id'); // Cambiar a unsignedInteger
            $table->foreign('materia_id')->references('id')->on('materias');
            $table->foreign('salon_id')->references('id')->on('salones');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clases');
    }
}
