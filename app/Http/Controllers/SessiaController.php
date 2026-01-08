<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User_session;

class SessiaController extends Controller
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
        return response()->json(["data"=>$session], 201);
    }

    public function show($id)
    {
        $session = User_session::findOrFail($id);
        return response()->json(["data"=>$session]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $session = User_session::findOrFail($id);

        $data = $request->validate([
            'session_token' => 'sometimes|required|string',
            'ip_address' => 'sometimes|nullable|string|max:45',
            'last_activity' => 'sometimes|nullable|date',
        ]);

        $session->update($data);
        return response()->json(["code"=>'success']);
    }


    public function destroy($id)
    {
        $session = User_session::findOrFail($id);
        $session->delete();

        return response()->json(['code' => 'success']);
    }
}
