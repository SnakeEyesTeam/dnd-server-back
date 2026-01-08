<?php

namespace App\Http\Controllers;

use App\Models\Map;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function store(Request $request)
    {
        map::create([
            'name' => $request->name,
            'path' => $request->path,
        ]);
    }

    public function destroy(string $id)
    {
        Map::destroy($id);
    }
}
