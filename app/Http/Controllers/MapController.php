<?php

namespace App\Http\Controllers;

use App\Models\Map;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Str;

class MapController extends Controller
{
    public function index()
    {
        $maps = Map::where('source_id', 'not like', '1')->get();
        $mymaps = Map::where('source_id', '1')->where('user_id', auth()->user()->id)->get();
        $finaldata = [];
        foreach ($maps as $entity) {
            $finaldata[] = array_merge(
                $entity->toArray(),
                ["source" => $entity->source]
            );
        }
        foreach ($mymaps as $entity) {
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
        ]);
        if ($request->hasFile('img')) {
            $imageName = Str::random(32) . "." . $request->img->getClientOriginalExtension();
            Storage::disk('public')->put($imageName, file_get_contents($request->img));
        }

        $entity = Map::create(
            array_merge(
                $validated,
                ['path' => $imageName],
                ['source_id' => 1],
                ['user_id' => auth()->user()->id]
            )
        );

        return response()->json($entity, 201);
    }

    public function destroy(string $id)
    {
        Map::destroy($id);
    }
}
