<?php



namespace App\Http\Controllers;

use App\Models\Salon;
use Illuminate\Http\Request;

class SalonController extends Controller
{
    public function index()
    {
        return response()->json(Salon::all());
    }

    public function store(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'capacidad_alumnos' => 'required|integer',
            'tipo' => 'required|string|max:255',
        ]);

        // Crear el salón
        $salon = Salon::create($request->all());

        // Retornar el salón creado
        return response()->json($salon, 201);
    }

    public function show($id)
    {
        $salon = Salon::findOrFail($id);
        return response()->json($salon);
    }

    public function update(Request $request, $id)
    {
        // Validar la solicitud
        $request->validate([
            'capacidad_alumnos' => 'sometimes|required|integer',
            'tipo' => 'sometimes|required|string|max:255',
        ]);

        // Buscar el salón y actualizar
        $salon = Salon::findOrFail($id);
        $salon->update($request->all());

        // Retornar el salón actualizado
        return response()->json($salon, 200);
    }

    public function destroy($id)
    {
        Salon::destroy($id);
        return response()->json(null, 204);
    }
}
