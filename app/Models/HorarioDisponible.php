<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
class HorarioDisponible extends Model
{
    use SoftDeletes;

    protected $table = 'horarios_disponibles';
    protected $fillable = ['dia', 'hora_inicio', 'hora_fin', 'profesor_id','soft_delete'];

    
     protected $dates = ['deleted_at'];
    public function profesor()
    {
        return $this->belongsTo(Profesor::class, 'profesor_id', 'cedula');
    }
}
