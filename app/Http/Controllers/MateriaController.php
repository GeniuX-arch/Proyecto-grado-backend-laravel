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

    //Post
    public function store(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'nombre' => 'required|string|max:255',
            'calificacion_alumno' => 'nullable|numeric',
            'experiencia' => 'nullable|numeric',
            'alumnos' => 'nullable|numeric',
        ]);

        // Crear la materia
        $materia = Materia::create($request->all());

        // Retornar la materia creada
        return response()->json($materia, 201);
    }

    //Get
    public function show($id)
    {
        $materia = Materia::findOrFail($id);
        return response()->json($materia);
    }


    //Put
    public function update(Request $request, $id)
    {
        // Validar la solicitud
        $request->validate([
            'nombre' => 'required|string|max:255',
            'calificacion_alumno' => 'nullable|numeric',
            'experiencia' => 'nullable|numeric',
            'alumnos' => 'nullable|numeric',
        ]);

        // Buscar la materia y actualizar
        $materia = Materia::findOrFail($id);
        $materia->update($request->all());

        // Retornar la materia actualizada
        return response()->json($materia, 200);
    }


/*
    public function destroy($id)
    {
        Materia::destroy($id);
        return response()->json(null, 204);
    }
*/
//softDelete
 public function destroy($id)
    {
        $salon = Materia::findOrFail($id);
        $salon->delete(); // Esto realizará un soft delete

        return response()->json(null, 204);
    }
}
