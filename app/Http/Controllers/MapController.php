<?php

namespace App\Http\Controllers;

use App\Models\Map;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index()
    {
        $maps = Map::all();

        return response()->json(["data"=>$maps]);
    }
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
