<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Entity;

class EntityController extends Controller
{
    public function index()
    {
        $entities = Entity::where('source_id', 'not like', '1')->get();
        $myentities = Entity::where('source_id', '1')->where('user_id', auth()->user()->id)->get();
        $finaldata = [];
        foreach ($entities as $entity) {
            $finaldata[] = array_merge(
                $entity->toArray(),
                ["source" => $entity->source]
            );
        }
        foreach ($myentities as $entity) {
            $finaldata[] = array_merge(
                $entity->toArray(),
                ["source" => $entity->source]
            );
        }

        return response()->json($finaldata);
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

        return response()->json($entity, 201);
    }

    public function destroy(string $id)
    {
        //
        Entity::destroy($id);
    }
}
