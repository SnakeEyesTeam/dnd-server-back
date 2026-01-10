<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GameSession;
use Storage;

class SessionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'data' => 'required|string',
            'bestiary' => 'sometimes|string',
            'imgs' => 'sometimes|array',
            'DM' => 'sometimes|string',
        ]);

        $imagePaths = [];

        if ($request->hasFile('imgs')) {
            foreach ($request->file('imgs') as $file) {
                $path = $file->store('public/session_img');
                $imagePaths[] = Storage::url($path);
            }
        }

        $validated['imgs'] = !empty($imagePaths) ? implode(',', $imagePaths) : null;

        $session = GameSession::create($validated);
        return response()->json(['code' => 'success']);
    }
    public function show($id)
    {
        $session = GameSession::find($id);
        if (!$session) {
            return response()->json(['code' => 'error'], 404);
        }
        return response()->json(['data' => $session], 200);
    }



    public function destroy($id)
    {
        $session = GameSession::find($id);
        if (!$session) {
            return response()->json(['code' => 'error'], 404);
        }

        $session->delete();

        return response()->json(['code' => 'success'], 200);
    }
}
