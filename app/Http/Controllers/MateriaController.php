<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    // Obtener todas las materias
    public function index()
    {
        return response()->json(Materia::all());
    }

    // Crear una nueva materia
    public function store(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'codigo' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'alumnos' => 'nullable|numeric', // Ajustado según el atributo $fillable
            'bloques' => 'nullable|numeric', // Ajustado según el atributo $fillable
            
        ]);

        // Crear la materia
        $materia = Materia::create($request->only(['codigo','nombre', 'alumnos','bloques'])); // Solo permite asignación de campos llenables

        // Retornar la materia creada
        return response()->json($materia, 201);
    }

    // Obtener una materia específica
    public function show($id)
    {
        $materia = Materia::findOrFail($id);
        return response()->json($materia);
    }

    // Actualizar una materia
    public function update(Request $request, $id)
    {
        // Validar la solicitud
        $request->validate([
            'codigo' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'alumnos' => 'nullable|numeric', // Ajustado según el atributo $fillable
            'bloques' => 'nullable|numeric', // Ajustado según el atributo $fillable
        ]);

        // Buscar la materia y actualizar
        $materia = Materia::findOrFail($id);
        $materia->update($request->only(['codigo','nombre', 'alumnos','bloques'])); // Solo permite asignación de campos llenables

        // Retornar la materia actualizada
        return response()->json($materia, 200);
    }

    // Soft delete de una materia
    public function destroy($id)
    {
        $materia = Materia::findOrFail($id);
        $materia->delete(); // Esto realizará un soft delete

        return response()->json(null, 204);
    }
}
