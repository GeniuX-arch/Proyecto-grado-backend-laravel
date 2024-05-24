<?php
namespace App\Http\Controllers;

use App\Models\ProfesorMateria;
use Illuminate\Http\Request;

class ProfesorMateriaController extends Controller
{
    public function index()
    {
        return response()->json(ProfesorMateria::all());
    }

    public function store(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'profesor_id' => 'required|integer|exists:profesores,cedula',
            'materia_id' => 'required|integer|exists:materias,id',
        ]);

        // Crear la relación profesor-materia
        $profesorMateria = ProfesorMateria::create($request->all());

        // Retornar la relación creada
        return response()->json($profesorMateria, 201);
    }

    public function show($id)
    {
        $profesorMateria = ProfesorMateria::findOrFail($id);
        return response()->json($profesorMateria);
    }

    public function update(Request $request, $id)
    {
        // Validar la solicitud
        $request->validate([
            'profesor_id' => 'sometimes|required|integer|exists:profesores,cedula',
            'materia_id' => 'sometimes|required|integer|exists:materias,id',
        ]);

        // Buscar la relación profesor-materia y actualizar
        $profesorMateria = ProfesorMateria::findOrFail($id);
        $profesorMateria->update($request->all());

        // Retornar la relación actualizada
        return response()->json($profesorMateria, 200);
    }

    public function destroy($id)
    {
        ProfesorMateria::destroy($id);
        return response()->json(null, 204);
    }
}
