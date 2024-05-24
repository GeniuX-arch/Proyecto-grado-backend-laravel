<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salon extends Model
{
    protected $table = 'salones';
    protected $primaryKey = 'id';
    protected $fillable = ['capacidad_alumnos', 'tipo'];

    public function clases()
    {
        return $this->hasMany(Clase::class, 'salon_id');
    }
}
