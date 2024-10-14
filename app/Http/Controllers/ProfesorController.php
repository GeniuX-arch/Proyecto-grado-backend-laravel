<?php


namespace App\Http\Controllers;
use App\Models\Profesor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


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
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'estado' => 'required|string|max:255',
        ]);
        if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('uploads', 'public');
    }

        // Create a new profesor with the image path
        $profesorData = $request->all();
        if (isset($imagePath)) {
            $profesorData['image_path'] = Storage::url($imagePath); //undefined type
        }

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

    // Check if a new image is uploaded
    if ($request->hasFile('image')) {
        // Delete the old image from storage
        if ($profesor->image_path) {
            Storage::delete(str_replace('/storage/', 'public/', $profesor->image_path));
        }

        // Store the new image and get the path
        $path = $request->file('image')->store('uploads', 'public');
        $profesor->image_path = Storage::url($path); // Update the URL of the image
    }

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
