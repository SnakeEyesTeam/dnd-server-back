<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User_session;

class SessionController extends Controller
{
    public function index()
    {
        $sessions = User_session::with('user')->get();
        return response()->json($sessions);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'session_token' => 'required|string',
            'ip_address' => 'nullable|string|max:45',
        ]);

        $session = User_session::create($data);
        return response()->json(["data" => $session], 201);
    }

    public function show($id)
    {
        $session = User_session::findOrFail($id);
        return response()->json(["data" => $session]);
    }

    public function destroy($id)
    {
        $session = User_session::findOrFail($id);
        $session->delete();

        return response()->json(['code' => 'success']);
    }
}
