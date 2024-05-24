<?php

namespace App\Http\Controllers;

use App\Models\HorarioDisponible;
use Illuminate\Http\Request;

class HorarioDisponibleController extends Controller
{
    public function index()
    {
        return response()->json(HorarioDisponible::all());
    }

    public function store(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'dia' => 'required|string|max:255',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i',
            'profesor_id' => 'required|integer|exists:profesores,cedula',
        ]);

        // Crear el horario disponible
        $horario = HorarioDisponible::create($request->all());

        // Retornar el horario creado
        return response()->json($horario, 201);
    }

    public function show($id)
    {
        $horario = HorarioDisponible::findOrFail($id);
        return response()->json($horario);
    }

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

    public function destroy($id)
    {
        HorarioDisponible::destroy($id);
        return response()->json(null, 204);
    }
}
