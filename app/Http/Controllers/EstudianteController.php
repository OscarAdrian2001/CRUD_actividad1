<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use Illuminate\Http\Request;

class EstudianteController extends Controller
{
    public function index()
    {
        return response()->json(Estudiante::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'email' => 'required|email'
        ]);

        $estudiante = Estudiante::create([
            'nombre' => $request->nombre,
            'email' => $request->email
        ]);

        return response()->json($estudiante, 201);
    }
    public function update(Request $request, $id)
    {
        $estudiante = Estudiante::find($id);

        if (!$estudiante) {
            return response()->json(['mensaje' => 'Estudiante no encontrado'], 404);
        }

        $request->validate([
            'nombre' => 'required|string|max:100',
            'email'  => 'required|email'
        ]);

        $estudiante->nombre = $request->nombre;
        $estudiante->email  = $request->email;
        $estudiante->save();

        return response()->json([
            'mensaje' => 'Estudiante actualizado correctamente',
            'data' => $estudiante
        ]);
    }
    public function destroy($id)
    {
        $estudiante = Estudiante::find($id);

        if (!$estudiante) {
            return response()->json(['error' => 'No encontrado'], 404);
        }

        $estudiante->delete();

        return response()->json(['mensaje' => 'Eliminado correctamente']);
    }


}
