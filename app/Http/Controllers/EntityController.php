<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Entity;
use Illuminate\Support\Facades\Storage;
use Str;

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
            'initiative' => 'nullable|string',
            'description' => 'nullable|string',
        ]);
        $idInBestiary = Str::random(16);
        if ($request->hasFile('img')) {
            $imageName = Str::random(32);
            Storage::disk('public')->put($imageName . "." . $request->img->getClientOriginalExtension(), file_get_contents($request->img));
            Storage::disk('public')->put($imageName . "original." . $request->img->getClientOriginalExtension(), file_get_contents($request->img));
        }

        $entity = Entity::create(
            array_merge(
                $validated,
                ['path' => $imageName],
                ['idInBestiary' => $idInBestiary],
                ['source_id' => 1],
                ['user_id' => auth()->user()->id]
            )
        );

        return response()->json($entity, 201);
    }

    public function destroy(string $id)
    {
        //
        Entity::destroy($id);
    }
}
