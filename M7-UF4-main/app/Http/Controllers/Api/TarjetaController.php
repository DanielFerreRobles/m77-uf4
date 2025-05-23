<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tarjeta;
use Illuminate\Support\Facades\Validator;

class TarjetaController extends Controller
{
    public function index()
    {
        $tarjetas = Tarjeta::all();
        return response()->json(['tarjetas' => $tarjetas], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'img' => 'required|url',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Datos inválidos',
                'errors' => $validator->errors()
            ], 422);
        }

        $tarjeta = Tarjeta::create($request->all());
        return response()->json(['tarjeta' => $tarjeta], 201);
    }

    public function show($id)
    {
        $tarjeta = Tarjeta::find($id);
        if (!$tarjeta) {
            return response()->json(['message' => 'Tarjeta no encontrada'], 404);
        }
        return response()->json(['tarjeta' => $tarjeta], 200);
    }

    public function update(Request $request, $id)
    {
        $tarjeta = Tarjeta::find($id);
        if (!$tarjeta) {
            return response()->json(['message' => 'Tarjeta no encontrada'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'img' => 'required|url',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Datos inválidos',
                'errors' => $validator->errors()
            ], 400);
        }

        $tarjeta->update($request->all());
        return response()->json(['tarjeta' => $tarjeta], 200);
    }

    public function updatePartial(Request $request, $id)
    {
        $tarjeta = Tarjeta::find($id);
        if (!$tarjeta) {
            return response()->json(['message' => 'Tarjeta no encontrada'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|string|max:255',
            'img' => 'sometimes|url',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Datos inválidos',
                'errors' => $validator->errors()
            ], 422);
        }

        $tarjeta->update($request->all());
        return response()->json(['tarjeta' => $tarjeta], 200);
    }

    public function destroy($id)
    {
        $tarjeta = Tarjeta::find($id);
        if (!$tarjeta) {
            return response()->json(['message' => 'Tarjeta no encontrada'], 404);
        }

        $tarjeta->delete();
        return response()->json(['message' => 'Tarjeta eliminada'], 200);
    }
}
