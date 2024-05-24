<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    public function index()
    {
        return response()->json(Materia::all());
    }

    public function store(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'nombre' => 'required|string|max:255',
            'calificacion_alumno' => 'nullable|numeric',
            'experiencia' => 'nullable|string|max:255',
        ]);

        // Crear la materia
        $materia = Materia::create($request->all());

        // Retornar la materia creada
        return response()->json($materia, 201);
    }

    public function show($id)
    {
        $materia = Materia::findOrFail($id);
        return response()->json($materia);
    }

    public function update(Request $request, $id)
    {
        // Validar la solicitud
        $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'calificacion_alumno' => 'sometimes|nullable|numeric',
            'experiencia' => 'sometimes|nullable|string|max:255',
        ]);

        // Buscar la materia y actualizar
        $materia = Materia::findOrFail($id);
        $materia->update($request->all());

        // Retornar la materia actualizada
        return response()->json($materia, 200);
    }

    public function destroy($id)
    {
        Materia::destroy($id);
        return response()->json(null, 204);
    }
}
