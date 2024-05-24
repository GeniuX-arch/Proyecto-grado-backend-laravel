<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    protected $fillable = ['nombre', 'calificacion_alumno', 'experiencia'];

    public function profesores()
    {
        return $this->hasMany(ProfesorMateria::class, 'materia_id');
    }

    public function clases()
    {
        return $this->hasMany(Clase::class, 'materia_id');
    }
}
