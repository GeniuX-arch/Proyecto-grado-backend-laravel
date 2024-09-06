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
        $request->validate([
            'capacidad_alumnos' => 'required|integer',
            'tipo' => 'required|string|max:255',
        ]);

        $salon = Salon::create($request->all());

        return response()->json($salon, 201);
    }

    public function show($id)
    {
        $salon = Salon::findOrFail($id);
        return response()->json($salon);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'capacidad_alumnos' => 'sometimes|required|integer',
            'tipo' => 'sometimes|required|string|max:255',
        ]);

        $salon = Salon::findOrFail($id);
        $salon->update($request->all());

        return response()->json($salon, 200);
    }

    public function destroy($id)
    {
        Salon::destroy($id);
        return response()->json(null, 204);
    }
}


 
