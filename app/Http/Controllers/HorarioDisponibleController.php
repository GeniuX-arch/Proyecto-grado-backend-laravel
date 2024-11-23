<?php

namespace App\Http\Controllers;

use App\Models\HorarioDisponible;
use Illuminate\Http\Request;

class HorarioDisponibleController extends Controller
{
    // Obtener todos los horarios disponibles o filtrarlos por profesor_id
    public function index(Request $request)
    {
        // Obtener el profesor_id de la consulta
        $name = $request->query('name');
        $profesorId = $request->query('profesor_id');
        $profesorNombre = $request->query('profesor_nombre');


        if($name){
        if ($profesorId) {
            // Filtrar por profesor_id si se proporciona
            $horarios = HorarioDisponible::with('profesor')
                ->where('profesor_id', $profesorId)
                ->get();
        }   elseif ($profesorNombre) {
            // Filtrar por el nombre del profesor si se proporciona
            $horarios = HorarioDisponible::with('profesor')
                ->whereHas('profesor', function ($query) use ($profesorNombre) {
                    $query->where('nombre', 'like', "%{$profesorNombre}%");
                })
                ->get();
        }
        else {
            // Si no se proporciona profesor_id, devolver todos los horarios con la relación
            $horarios = HorarioDisponible::with('profesor')->get();
        }

        // Formatear los datos para devolver solo lo necesario
        $resultado = $horarios->map(function ($horario) {
            return [
                'id' => $horario->id,
                'profesor_nombre' => $horario->profesor->nombre,
                'dia' => $horario->dia,
                'hora_inicio' => $horario->hora_inicio,
                'hora_fin' => $horario->hora_fin,
            ];
        });

        return response()->json($resultado);
    }else{
        return response()->json(HorarioDisponible::all());
    }}

    // Crear un nuevo horario disponible
    public function store(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'dia' => 'required|string|max:255',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i',
            'profesor_id' => 'required|integer|exists:profesores,id',
        ]);

        // Crear el horario disponible
        $horario = HorarioDisponible::create($request->all());

        // Retornar el horario creado
        return response()->json($horario, 201);
    }

    // Obtener un horario disponible específico
    public function show($id)
    {
        // Buscar el horario con la relación necesaria
        $horario = HorarioDisponible::with('profesor')->findOrFail($id);

        // Formatear la respuesta
        $resultado = [
            'id' => $horario->id,
            'profesor_nombre' => $horario->profesor->nombre,
            'dia' => $horario->dia,
            'hora_inicio' => $horario->hora_inicio,
            'hora_fin' => $horario->hora_fin,
        ];

        return response()->json($resultado);
    }

    // Actualizar un horario disponible
    public function update(Request $request, $id)
    {
        // Validar la solicitud
        $request->validate([
            'dia' => 'sometimes|required|string|max:255',
            'hora_inicio' => 'sometimes|required|date_format:H:i',
            'hora_fin' => 'sometimes|required|date_format:H:i',
            'profesor_id' => 'sometimes|required|integer|exists:profesores,id',
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
        $horario = HorarioDisponible::findOrFail($id);
        $horario->delete(); // Esto realizará un soft delete

        return response()->json(null, 204);
    }
}
