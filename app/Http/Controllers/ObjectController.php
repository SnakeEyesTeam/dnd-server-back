<?php

namespace App\Http\Controllers;

use App\Models\MapObject;
use Illuminate\Http\Request;

class ObjectController extends Controller
{
    public function index()
    {
        $objects = MapObject::all();
        return response()->json($objects);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:80',
            'path' => 'sometimes|string',
            'user_id' => 'sometimes|integer',
            'source_id' => 'sometimes|integer',
        ]);

        $object = MapObject::create($validated);

        return response()->json(["data" => $object], 201);
    }

    public function destroy($id)
    {
        $object = MapObject::findOrFail($id);
        $object->delete();

        return response()->json(null, 204);
    }
}