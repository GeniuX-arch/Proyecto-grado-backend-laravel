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
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif',
            'estado' => 'required|string|max:255',
        ]);

        $imageUrl = null;

        // Verificar si se ha subido una imagen
        if ($request->hasFile('image')) {
            // Contar cuántas imágenes ya hay en el directorio 'public/images'
            $count = count(Storage::files('public/images'));
            $consecutivo = $count + 1; // Sumar 1 al número actual de archivos

            // Obtener la extensión del archivo
            $extension = $request->file('image')->getClientOriginalExtension();

            // Crear un nombre de archivo basado en el consecutivo, ej. "imagen_1.jpg"
            $fileName = 'imagen_' . $consecutivo . '.' . $extension;

            // Guardar la imagen en el directorio 'public/images' con el nombre generado
            $path = $request->file('image')->storeAs('public/images', $fileName);

            // Obtener la URL de la imagen
            $imageUrl = Storage::url($path);
        }

        // Crear un nuevo profesor con los datos validados
        $profesorData = $request->all();
        if ($imageUrl) {
            $profesorData['image_path'] = $imageUrl; // Guardar la URL de la imagen
        }

        // Crear el profesor
        $profesor = Profesor::create($profesorData);

        // Retornar el profesor creado
        return response()->json($profesor, 201);
    }

    public function show($id)
    {
        $profesor = Profesor::findOrFail($id);
        return response()->json($profesor);
    }

    public function update(Request $request, $id)
    {
        // Validar la solicitud
        $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'tipo_contrato' => 'sometimes|required|string|max:255',
            'estado' => 'sometimes|required|string|max:255',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Buscar el profesor
        $profesor = Profesor::findOrFail($id);

        $imageUrl = $profesor->image_path; // Mantener la URL actual de la imagen si no se actualiza

        // Verificar si se ha subido una nueva imagen
        if ($request->hasFile('image')) {
            // Eliminar la imagen antigua del almacenamiento
            if ($profesor->image_path) {
                Storage::delete(str_replace('/storage/', 'public/', $profesor->image_path));
            }

            // Contar cuántas imágenes ya hay en el directorio 'public/images'
            $count = count(Storage::files('public/images'));
            $consecutivo = $count + 1; // Sumar 1 al número actual de archivos

            // Obtener la extensión del archivo
            $extension = $request->file('image')->getClientOriginalExtension();

            // Crear un nombre de archivo basado en el consecutivo
            $fileName = 'imagen_' . $consecutivo . '.' . $extension;

            // Guardar la imagen en el directorio 'public/images' con el nombre generado
            $path = $request->file('image')->storeAs('public/images', $fileName);

            // Actualizar la URL de la imagen
            $imageUrl = Storage::url($path);
        }

        // Actualizar los datos del profesor
        $profesorData = $request->all();
        $profesorData['image_path'] = $imageUrl; // Actualizar la URL de la imagen si fue cambiada
        $profesor->update($profesorData);

        // Retornar el profesor actualizado
        return response()->json($profesor, 200);
    }

    // SoftDelete
    public function destroy($id)
    {
        $profesor = Profesor::findOrFail($id);
        $profesor->delete(); // Esto realizará un soft delete
        return response()->json(null, 204);
    }
}
