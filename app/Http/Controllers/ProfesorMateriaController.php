<?php

namespace App\Http\Controllers;

use App\Models\ProfesorMateria;
use Illuminate\Http\Request;

class ProfesorMateriaController extends Controller
{
    // Obtener todas las relaciones o filtrar por profesor_id
    public function index(Request $request){
    
    $name = $request->query('name');
    $profesorId = $request->query('profesor_id');
    $profesorNombre = $request->query('profesor_nombre');
    $materiaNombre = $request->query('materia_nombre');
    if($name){

    // Base de la consulta
    $query = ProfesorMateria::with(['profesor', 'materia']);
    // Aplicar filtros si están presentes
    $hasFilters = false;

    if ($profesorId) {
        $query->where('profesor_id', $profesorId);
        $hasFilters = true;
    }

    if ($profesorNombre) {
        $query->whereHas('profesor', function ($subQuery) use ($profesorNombre) {
            $subQuery->where('nombre', 'like', "%{$profesorNombre}%");
        });
        $hasFilters = true;
    }

    if ($materiaNombre) {
        $query->whereHas('materia', function ($subQuery) use ($materiaNombre) {
            $subQuery->where('nombre', 'like', "%{$materiaNombre}%");
        });
        $hasFilters = true;
    }

    // Limitar a 20 resultados solo si hay filtros
    if ($hasFilters) {
        $query->limit(20);
    }

    // Obtener resultados
    $relaciones = $query->get();

    // Formatear la respuesta
    $resultado = $relaciones->map(function ($relacion) {
        return [
            'id' => $relacion->id,
            'profesor_nombre' => $relacion->profesor->nombre,
            'materia_nombre' => $relacion->materia->nombre,
            'experiencia' => $relacion->experiencia,
            'calificacion_alumno' => $relacion->calificacion_alumno,
        ];
    });

    return response()->json($resultado);
    }else{
        return response()->json(ProfesorMateria::all());
    }}

    // Crear una nueva relación profesor-materia
    public function store(Request $request)
    {
        $request->validate([
            'profesor_id' => 'required|integer|exists:profesores,id',
            'materia_id' => 'required|integer|exists:materias,id',
            'experiencia' => 'nullable|numeric|min:0',
            'calificacion_alumno' => 'nullable|numeric|between:2,5',
        ]);

        $profesorMateria = ProfesorMateria::create($request->only([
            'profesor_id', 'materia_id', 'experiencia', 'calificacion_alumno'
        ]));

        return response()->json($profesorMateria->load(['profesor', 'materia']), 201);
    }

    // Obtener una relación específica
    public function show($id)
    {
        $profesorMateria = ProfesorMateria::with(['profesor', 'materia'])->findOrFail($id);

        $resultado = [
            'id' => $profesorMateria->id,
            'profesor_nombre' => $profesorMateria->profesor->nombre,
            'materia_nombre' => $profesorMateria->materia->nombre,
            'experiencia' => $profesorMateria->experiencia,
            'calificacion_alumno' => $profesorMateria->calificacion_alumno,
        ];

        return response()->json($resultado);
    }

    // Actualizar una relación profesor-materia
    public function update(Request $request, $id)
    {
        $request->validate([
            'profesor_id' => 'sometimes|required|integer|exists:profesores,id',
            'materia_id' => 'sometimes|required|integer|exists:materias,id',
            'experiencia' => 'nullable|numeric|min:0',
            'calificacion_alumno' => 'nullable|numeric|between:2,5',
        ]);

        $profesorMateria = ProfesorMateria::findOrFail($id);
        $profesorMateria->update($request->only([
            'profesor_id', 'materia_id', 'experiencia', 'calificacion_alumno'
        ]));

        return response()->json($profesorMateria->load(['profesor', 'materia']), 200);
    }

    // Eliminar una relación profesor-materia
    public function destroy($id)
    {
        $profesorMateria = ProfesorMateria::findOrFail($id);
        $profesorMateria->delete();

        return response()->json(['message' => 'Relación eliminada con éxito'], 204);
    }
}
