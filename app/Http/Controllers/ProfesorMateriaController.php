<?php

namespace App\Http\Controllers;

use App\Models\ProfesorMateria;
use Illuminate\Http\Request;

class ProfesorMateriaController extends Controller
{
    // Obtener todas las relaciones profesor-materia o filtrar por profesor_id
    public function index(Request $request)
    {
        // Si hay un profesor_id en la consulta, filtrar por él
        $profesorId = $request->query('profesor_id');

        if ($profesorId) {
            // Asegúrate de que el profesor_id es válido
            return response()->json(ProfesorMateria::where('profesor_id', $profesorId)->get());
        }

        // Si no hay profesor_id, devuelve todas las relaciones
        return response()->json(ProfesorMateria::all());
    }

    // Crear una nueva relación profesor-materia
    public function store(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'profesor_id' => 'required|integer|exists:profesores,id',
            'materia_id' => 'required|integer|exists:materias,id',
            'experiencia' => 'nullable|numeric',
            'calificacion_alumno' => 'nullable|numeric',
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
            'experiencia' => 'nullable|numeric',
            'calificacion_alumno' => 'nullable|numeric',
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
        $profesorMateria = ProfesorMateria::findOrFail($id);
        $profesorMateria->delete(); // Esto realizará un soft delete

        return response()->json(null, 204);
    }
}
