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

    public function show($id)
    {
        $object = MapObject::findOrFail($id);
        return response()->json($object);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:80',
            'path' => 'required|string|max:255',
        ]);

        $object = MapObject::create($validated);

        return response()->json($object, 201);
    }

    public function update(Request $request, $id)
    {
        $object = MapObject::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:80',
            'path' => 'required|string|max:255',
        ]);

        $object->update($validated);

        return response()->json($object);
    }

    public function destroy($id)
    {
        $object = MapObject::findOrFail($id);
        $object->delete();

        return response()->json(null, 204);
    }
}