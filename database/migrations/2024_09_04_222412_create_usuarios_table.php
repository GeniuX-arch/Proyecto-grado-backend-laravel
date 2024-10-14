<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('rol');
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedInteger('profesor_id')->nullable(); // Añadir el campo para la clave foránea

            $table->foreign('profesor_id')->references('id')->on('profesores')->onDelete('set null'); 

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};