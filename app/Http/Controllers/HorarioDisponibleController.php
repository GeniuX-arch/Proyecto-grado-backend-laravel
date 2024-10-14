<?php

namespace App\Http\Controllers;

use App\Models\HorarioDisponible;
use Illuminate\Http\Request;

class HorarioDisponibleController extends Controller
{
    // Obtener todos los horarios disponibles
    public function index()
    {
        return response()->json(HorarioDisponible::all());
    }

    // Crear un nuevo horario disponible
    public function store(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'dia' => 'required|string|max:255',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i',
            'profesor_id' => 'required|integer|exists:profesores,cedula', // Asegúrate de que "cedula" sea la columna correcta
        ]);

        // Crear el horario disponible
        $horario = HorarioDisponible::create($request->all());

        // Retornar el horario creado
        return response()->json($horario, 201);
    }

    // Obtener un horario disponible específico
    public function show($id)
    {
        $horario = HorarioDisponible::findOrFail($id);
        return response()->json($horario);
    }

    // Actualizar un horario disponible
    public function update(Request $request, $id)
    {
        // Validar la solicitud
        $request->validate([
            'dia' => 'sometimes|required|string|max:255',
            'hora_inicio' => 'sometimes|required|date_format:H:i',
            'hora_fin' => 'sometimes|required|date_format:H:i',
            'profesor_id' => 'sometimes|required|integer|exists:profesores,cedula',
        ]);

        // Buscar el horario y actualizar
        $horario = HorarioDisponible::findOrFail($id);
        $horario->update($request->all());

        // Retornar el horario actualizado
        return response()->json($horario, 200);
    }

    // Soft delete de un horario disponible
    public function destroy($id)
    {
        $horario = HorarioDisponible::findOrFail($id); // Cambié de "$salon" a "$horario" para mantener consistencia
        $horario->delete(); // Esto realizará un soft delete

        return response()->json(null, 204);
    }
}
