<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profesor extends Model
{
    use SoftDeletes;
    protected $table = 'profesores';
    protected $primaryKey = 'cedula';
    protected $fillable = ['cedula', 'nombre', 'tipo_contrato', 'estado','soft_delete'];

  
     protected $dates = ['deleted_at'];
    public function materias()
    {
        return $this->hasMany(ProfesorMateria::class, 'profesor_id', 'cedula');
    }

    public function horariosDisponibles()
    {
        return $this->hasMany(HorarioDisponible::class, 'profesor_id', 'cedula');
    }
}
