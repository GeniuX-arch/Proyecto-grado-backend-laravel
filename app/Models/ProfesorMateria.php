<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfesorMateria extends Model
{
    use SoftDeletes;
    protected $table = 'profesor_materia';
    protected $fillable = ['profesor_id', 'materia_id','soft_delete'];

     protected $dates = ['deleted_at'];

    public function profesor()
    {
        return $this->belongsTo(Profesor::class, 'profesor_id', 'cedula');
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }
}