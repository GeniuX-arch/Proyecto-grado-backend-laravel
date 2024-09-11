<?php


namespace App\Http\Controllers;
use App\Models\Profesor;
use Illuminate\Http\Request;

class ProfesorController extends Controller
{
    public function index()
    {
        return response()->json(Profesor::all());
    }

    public function store(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'cedula' => 'required|integer|unique:profesores,cedula',
            'nombre' => 'required|string|max:255',
            'tipo_contrato' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
            'soft_delete' => 1
        ]);

        // Crear el profesor
        $profesor = Profesor::create($request->all());

        // Retornar el profesor creado
        return response()->json($profesor, 201);
    }


    //get
    public function show($id)
    {
        $profesor = Profesor::findOrFail($id);
        return response()->json($profesor);
    }





    //Put
    public function update(Request $request, $id)
    {
        // Validar la solicitud
        $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'tipo_contrato' => 'sometimes|required|string|max:255',
            'estado' => 'sometimes|required|string|max:255',
        ]);

        // Buscar el profesor y actualizar
        $profesor = Profesor::findOrFail($id);
        $profesor->update($request->all());

        // Retornar el profesor actualizado
        return response()->json($profesor, 200);
    }




/*
    //Eliminado fuerte
    public function destroy($id)
    {
        Profesor::destroy($id);
        return response()->json(null, 204);
    }
*/
    //softDelete
 public function destroy($id)
    {
        $salon = Profesor::findOrFail($id);
        $salon->delete(); // Esto realizará un soft delete

        return response()->json(null, 204);
    }

}
