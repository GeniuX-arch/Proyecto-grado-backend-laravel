<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Salon extends Model
{
    use SoftDeletes;
    protected $table = 'salones';
    protected $primaryKey = 'id';
    protected $fillable = ['codigo','capacidad_alumnos','tipo','soft_delete'];

    protected $dates = ['deleted_at'];


    public function clases()
    {
        return $this->hasMany(Clase::class, 'salon_id');
    }
}
