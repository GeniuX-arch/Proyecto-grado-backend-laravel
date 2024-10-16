<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfesorMateria extends Model
{
    use SoftDeletes;
    protected $table = 'profesor_materia';
    protected $primaryKey = 'id';
    protected $fillable = ['profesor_id', 'materia_id','experiencia','calificacion_alumno'];

     protected $dates = ['deleted_at'];

    public function profesor()
    {
        return $this->belongsTo(Profesor::class, 'profesor_id');
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }
}  