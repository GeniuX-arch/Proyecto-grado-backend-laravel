<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfesorMateria extends Model
{
    protected $table = 'profesor_materia';
    protected $fillable = ['profesor_id', 'materia_id'];

    public function profesor()
    {
        return $this->belongsTo(Profesor::class, 'profesor_id', 'cedula');
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }
}