<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profesor extends Model
{
    use SoftDeletes;
    protected $table = 'profesores';
    protected $primaryKey = 'id';
    protected $fillable = ['tipo_cedula','cedula','nombre', 'tipo_contrato', 'estado','image_path'];

  
     protected $dates = ['deleted_at'];
    public function materias()
    {
        return $this->hasMany(ProfesorMateria::class, 'profesor_id');
    }

    public function horariosDisponibles()
    {
        return $this->hasMany(HorarioDisponible::class, 'profesor_id');
    }    
    public function clase()
    {
        return $this->hasMany(Clase::class, 'profesor_id');
    }
}