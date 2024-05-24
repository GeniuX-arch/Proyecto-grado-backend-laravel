<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HorarioDisponible extends Model
{
    protected $table = 'horarios_disponibles';
    protected $fillable = ['dia', 'hora_inicio', 'hora_fin', 'profesor_id'];

    public function profesor()
    {
        return $this->belongsTo(Profesores::class, 'profesor_id', 'cedula');
    }
}
