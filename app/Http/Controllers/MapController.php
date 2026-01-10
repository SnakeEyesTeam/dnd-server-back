<?php

namespace App\Http\Controllers;

use App\Models\Map;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index()
    {
        $maps = Map::all();

        return response()->json(["data" => $maps]);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'path' => 'nullable|string',
            'user_id' => 'nullable|integer',
            'source_id' => 'nullable|integer',
        ]);

        $map = Map::create($validated);

        return response()->json(["data" => $map], 201);
    }

    public function destroy(string $id)
    {
        Map::destroy($id);
    }
}
