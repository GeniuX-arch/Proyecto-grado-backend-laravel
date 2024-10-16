<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
class HorarioDisponible extends Model
{
    use SoftDeletes;

    protected $table = 'horarios_disponibles';
    protected $primaryKey = 'id';
    protected $fillable = ['dia', 'hora_inicio', 'hora_fin', 'profesor_id'];

    
     protected $dates = ['deleted_at'];
    public function profesor()
    {
        return $this->belongsTo(Profesor::class, 'profesor_id');
    }
}
