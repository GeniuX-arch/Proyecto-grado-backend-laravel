<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Materia extends Model
{
    use SoftDeletes;
    protected $fillable = ['nombre', 'calificacion_alumno','alumnos', 'experiencia','soft_delete'];

     protected $dates = ['deleted_at'];
    public function profesores()
    {
        return $this->hasMany(ProfesorMateria::class, 'materia_id');
    }

    public function clases()
    {
        return $this->hasMany(Clase::class, 'materia_id');
    }
}
