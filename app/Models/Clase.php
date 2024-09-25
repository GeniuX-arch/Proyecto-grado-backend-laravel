<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Clase extends Model
{
    use SoftDeletes;
    protected $fillable = ['grupo', 'dia_semana', 'hora_inicio', 'hora_fin', 'alumnos','materia_id', 'salon_id','soft_delete'];
     protected $dates = ['deleted_at'];

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }

    public function salon()
    {
        return $this->belongsTo(Salon::class, 'salon_id');
    }
}
