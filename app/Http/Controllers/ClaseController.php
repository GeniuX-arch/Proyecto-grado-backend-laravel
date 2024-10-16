<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use Illuminate\Http\Request;

class ClaseController extends Controller
{
    // Obtener todas las clases o filtrar por profesor_id
    public function index(Request $request)
    {
        // Si hay un profesor_id en la consulta, filtrar por él
        $profesorId = $request->query('profesor_id');

        if ($profesorId) {
            // Asegúrate de que el profesor_id es válido
            return response()->json(Clase::where('profesor_id', $profesorId)->get());
        }

        // Si no hay profesor_id, devuelve todas las clases
        return response()->json(Clase::all());
    }

    public function store(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'grupo' => 'required|string|max:255',
            'dia_semana' => 'required|string|max:255',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i',
            'materia_id' => 'required|integer|exists:materias,id',
            'salon_id' => 'required|integer|exists:salones,id',
            'alumnos' => 'required|integer',
            'profesor_id' => 'required|integer|exists:profesores,id',
        ]);

        // Crear la clase
        $clase = Clase::create($request->all());

        // Retornar la clase creada
        return response()->json($clase, 201);
    }

    public function show($id)
    {
        $clase = Clase::findOrFail($id);
        return response()->json($clase);
    }

    public function update(Request $request, $id)
    {
        // Validar la solicitud
        $request->validate([
            'grupo' => 'sometimes|required|string|max:255',
            'dia_semana' => 'sometimes|required|string|max:255',
            'hora_inicio' => 'sometimes|required|date_format:H:i',
            'hora_fin' => 'sometimes|required|date_format:H:i',
            'materia_id' => 'sometimes|required|integer|exists:materias,id',
            'salon_id' => 'sometimes|nullable|integer|exists:salones,id',
            'alumnos' => 'sometimes|integer',
            'profesor_id' => 'sometimes|nullable|integer|exists:profesores,id',
        ]);

        // Buscar la clase y actualizar
        $clase = Clase::findOrFail($id);
        $clase->update($request->all());

        // Retornar la clase actualizada
        return response()->json($clase, 200);
    }

    public function destroy($id)
    {
        $clase = Clase::findOrFail($id);
        $clase->delete(); // Soft delete

        return response()->json(null, 204);
    }
}
