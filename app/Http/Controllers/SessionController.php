<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GameSession;
use Storage;
use Str;

class SessionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'path' => 'required|string',
        ]);
        $data = Str::random(32) . ".json";
        $bestiary = Str::random(32) . ".json";

        $session = GameSession::create(array_merge(
            $validated,
            [
                "DM" => auth()->user()->id,
                'data' => $data,
                "bestiary" => $bestiary
            ],
        ));
        Storage::disk('public')->put($data, json_encode([
            'id' => $session->id,
            'name' => $session->name,
            'currentMap' => null,
            "DM" => auth()->user(),
            'maps' => [],
            'characters' => [],
            'mapsData' => ['' => ''],
            "imgs" => "",
            'note' => '',
            'users' => ''
        ]));
        Storage::disk('public')->put($bestiary, json_encode([]));
        return response()->json($session, 201);
    }
    public function show($id)
    {
        $session = GameSession::select(['data', 'id', 'bestiary'])->find($id);

        if (!$session) {
            return response()->json(null, 404);
        }

        return response()->json($session, 200);
    }

    public function destroy($id)
    {
        $session = GameSession::find($id);

        if (!$session) {
            return response()->json(['code' => 'error'], 404);
        }
        $session->delete();

        return response()->json(['id' => $session->id], 200);
    }

    public function pushImg(Request $request)
    {
        if ($request->hasFile('img')) {
            $imageName = Str::random(32) . "." . $request->img->getClientOriginalExtension();
            Storage::disk('public')->put($imageName, file_get_contents($request->img));

            return response()->json($imageName, 201);
        }
        return response()->json(null, 400);
    }

    public function JSON(Request $request, $path)
    {
        Storage::disk('public')->put($path, json_encode($request->data));

        return response()->json(null, 200);
    }

    public function static($path)
    {
        $filePath = storage_path('app/public/' . $path);

        if (!file_exists($filePath)) {
            return response()->json(null, 404);
        }

        return response()->file($filePath);
    }
}
