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
        
        $name = $request->query('name');

        if($name){
        if ($profesorId) {
            $clases = Clase::with(['profesor', 'materia', 'salon'])
                ->where('profesor_id', $profesorId)
                ->get();
        } else {
            // Obtener todas las clases con relaciones
            $clases = Clase::with(['profesor', 'materia', 'salon'])->get();
        }

        // Formatear el resultado para que no incluya los IDs y devuelva solo lo necesario
        $resultado = $clases->map(function ($clase) {
            return [
                'id' => $clase->id,
                'profesor_nombre' => $clase->profesor->nombre,
                'materia_nombre' => $clase->materia->nombre,
                'salon_codigo' => $clase->salon->codigo,
                'grupo' => $clase->grupo,
                'dia_semana' => $clase->dia_semana,
                'hora_inicio' => $clase->hora_inicio,
                'hora_fin' => $clase->hora_fin,
            ];
        });

        return response()->json($resultado);
    }else{
        return response()->json(Clase::all());
    }
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
    // Buscar la clase con las relaciones necesarias
    $clase = Clase::with(['profesor', 'materia', 'salon'])->findOrFail($id);

    // Formatear el resultado
    $resultado = [

        'id' => $clase->id,
        'profesor_nombre' => $clase->profesor->nombre,
        'materia_nombre' => $clase->materia->nombre,
        'salon_codigo' => $clase->salon->codigo,
        'grupo' => $clase->grupo,
        'dia_semana' => $clase->dia_semana,
        'hora_inicio' => $clase->hora_inicio,
        'hora_fin' => $clase->hora_fin,
    ];

    return response()->json($resultado);
}
/*
    public function show($id)
    {
        $clase = Clase::findOrFail($id);
        return response()->json($clase);
    }
        */

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
