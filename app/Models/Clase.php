<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clase extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';
    protected $fillable = ['grupo', 'dia_semana', 'hora_inicio', 'hora_fin', 'alumnos', 'materia_id', 'salon_id', 'profesor_id'];

    protected $dates = ['deleted_at'];

    // Accesores para cambiar el nombre de los atributos


    public function getHoraInicioAttribute($value)
    {
        return date('H:i', strtotime($value)); // Devuelve hora en formato HH:mm
    }

    public function getHoraFinAttribute($value)
    {
        return date('H:i', strtotime($value)); // Devuelve hora en formato HH:mm
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }

    public function salon()
    {
        return $this->belongsTo(Salon::class, 'salon_id');
    } 
    public function profesor()
    {
        return $this->belongsTo(Profesor::class, 'profesor_id');
    }
}
