<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHorariosDisponiblesTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('horarios_disponibles');
        Schema::create('horarios_disponibles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('dia');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->integer('profesor_id');
            $table->foreign('profesor_id')->references('cedula')->on('profesores');
        });
    }

    public function down()
    {
        Schema::dropIfExists('horarios_disponibles');
    }
}
