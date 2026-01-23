<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Str;

class CharacterController extends Controller
{
    public function index(Request $request)
    {
        $characters = Character::where('user_id', $request->id)->get();

        return response($characters, 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'initiative' => 'string',
        ]);
        if ($request->hasFile('img')) {
            $imageName = Str::random(32) . "." . $request->img->getClientOriginalExtension();
            Storage::disk('public')->put($imageName, file_get_contents($request->img));

            $character = Character::create(
                array_merge(
                    $validated,
                    ['path' => $imageName],
                    ['user_id' => auth()->user()->id]
                )
            );

            return response()->json($character, 201);
        }
    }

    public function destroy(Request $request)
    {
        $character = Character::find($request->id);

        if (!$character) {
            return response()->json(['code' => 'error'], 404);
        }
        $character->delete();

        return response()->json(['id' => $character->id], 200);
    }
}
