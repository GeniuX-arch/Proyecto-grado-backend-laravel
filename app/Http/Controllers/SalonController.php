<?php

namespace App\Http\Controllers;

use App\Models\Salon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalonController extends Controller
{
    use SoftDeletes; // Se usa el trait aquí para manejar soft deletes

    public function index()
    {
        return response()->json(Salon::all());
    }

    public function store(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'codigo' => 'required|string|max:255', // Agregado según el atributo $fillable
            'capacidad_alumnos' => 'required|integer',
            'tipo' => 'required|string|max:255',
            // 'soft_delete' no se debe validar ni incluir en la creación, ya que es un campo gestionado por el sistema
        ]);

        // Crear el salón
        $salon = Salon::create($request->only(['codigo', 'capacidad_alumnos', 'tipo'])); // Se excluye 'soft_delete'

        // Retornar el salón creado
        return response()->json($salon, 201);
    }

    public function show($id)
    {
        $salon = Salon::findOrFail($id);
        return response()->json($salon);
    }

    public function update(Request $request, $id)
    {
        // Validar la solicitud
        $request->validate([
            'codigo' => 'sometimes|required|string|max:255', // Agregado según el atributo $fillable
            'capacidad_alumnos' => 'sometimes|required|integer',
            'tipo' => 'sometimes|required|string|max:255',
            // 'soft_delete' no se debe validar ni incluir en la actualización
        ]);

        // Buscar el salón y actualizar
        $salon = Salon::findOrFail($id);
        $salon->update($request->only(['codigo', 'capacidad_alumnos', 'tipo'])); // Se excluye 'soft_delete'

        // Retornar el salón actualizado
        return response()->json($salon, 200);
    }

    // Soft delete de un salón
    public function destroy($id)
    {
        $salon = Salon::findOrFail($id);
        $salon->delete(); // Esto realizará un soft delete

        return response()->json(null, 204);
    }
}
