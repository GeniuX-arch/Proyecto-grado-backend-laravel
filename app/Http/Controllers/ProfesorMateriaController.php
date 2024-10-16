<?php

namespace App\Http\Controllers;
use App\Models\ProfesorMateria;
use Illuminate\Http\Request;

class ProfesorMateriaController extends Controller
{
    // Obtener todas las relaciones profesor-materia
    public function index()
    {
        return response()->json(ProfesorMateria::all());
    }

    // Crear una nueva relación profesor-materia
    public function store(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'profesor_id' => 'required|integer|exists:profesores,id',
            'materia_id' => 'required|integer|exists:materias,id',
            'experiencia' => 'nullable|numeric', // Agregado según el atributo $fillable
            'calificacion_alumno' => 'nullable|numeric', // Agregado según el atributo $fillable
        ]);

        // Crear la relación profesor-materia
        $profesorMateria = ProfesorMateria::create($request->only(['profesor_id', 'materia_id', 'experiencia', 'calificacion_alumno']));

        // Retornar la relación creada
        return response()->json($profesorMateria, 201);
    }

    // Obtener una relación profesor-materia específica
    public function show($id)
    {
        $profesorMateria = ProfesorMateria::findOrFail($id);
        return response()->json($profesorMateria);
    }

    // Actualizar una relación profesor-materia
    public function update(Request $request, $id)
    {
        // Validar la solicitud
        $request->validate([
            'profesor_id' => 'sometimes|required|integer|exists:profesores,id',
            'materia_id' => 'sometimes|required|integer|exists:materias,id',
            'experiencia' => 'nullable|numeric', // Agregado según el atributo $fillable
            'calificacion_alumno' => 'nullable|numeric', // Agregado según el atributo $fillable
        ]);

        // Buscar la relación profesor-materia y actualizar
        $profesorMateria = ProfesorMateria::findOrFail($id);
        $profesorMateria->update($request->only(['profesor_id', 'materia_id', 'experiencia', 'calificacion_alumno']));

        // Retornar la relación actualizada
        return response()->json($profesorMateria, 200);
    }

    // Soft delete de una relación profesor-materia
    public function destroy($id)
    {
        $profesorMateria = ProfesorMateria::findOrFail($id); // Cambié de "$salon" a "$profesorMateria" para mantener consistencia
        $profesorMateria->delete(); // Esto realizará un soft delete

        return response()->json(null, 204);
    }
}
