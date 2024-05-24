<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clase extends Model
{
    protected $fillable = ['grupo', 'dia_semana', 'hora_inicio', 'hora_fin', 'materia_id', 'salon_id'];

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }

    public function salon()
    {
        return $this->belongsTo(Salones::class, 'salon_id');
    }
}
