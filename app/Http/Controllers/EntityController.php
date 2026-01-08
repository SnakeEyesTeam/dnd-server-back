<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Entity;

class EntityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        Entity::create([
            'name' => $request-> name,
            'path' => $request -> path,
            'iniciative' => $request -> iniciative,
            'discription' => $request -> discription,
            'size' => $request -> size
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Entity::destroy($id);
    }
}
