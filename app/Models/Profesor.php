<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    protected $table = 'profesores';
    protected $primaryKey = 'cedula';
    protected $fillable = ['cedula', 'nombre', 'tipo_contrato', 'estado'];

    public function materias()
    {
        return $this->hasMany(ProfesorMateria::class, 'profesor_id', 'cedula');
    }

    public function horariosDisponibles()
    {
        return $this->hasMany(HorarioDisponible::class, 'profesor_id', 'cedula');
    }
}
