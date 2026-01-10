<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Entity;

class EntityController extends Controller
{
    public function index()
    {
        $entities = Entity::all();

        return response()->json(["data" => $entities]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'path' => 'nullable|string',
            'iniciative' => 'nullable|string',
            'discription' => 'nullable|string',
            'size' => 'nullable|string',
            'user_id' => 'sometimes|integer',
            'source_id' => 'sometimes|integer'
        ]);

        $entity = Entity::create($validated);

        return response()->json(["data" => $entity], 201);
    }

    public function destroy(string $id)
    {
        //
        Entity::destroy($id);
    }
}
