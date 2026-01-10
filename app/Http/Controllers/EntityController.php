<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Entity;

class EntityController extends Controller
{
    public function index()
    {
        $entities = Entity::all();
        
        return response()->json(["data"=>$entities]);
    }

    public function store(Request $request)
    {

        Entity::create([
            'name' => $request->name,
            'path' => $request->path,
            'iniciative' => $request->iniciative,
            'discription' => $request->discription,
            'size' => $request->size
        ]);
    }

    public function destroy(string $id)
    {
        //
        Entity::destroy($id);
    }
}
