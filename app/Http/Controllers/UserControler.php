<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Str;
use Validator;

use Laravel\Sanctum\HasApiTokens;


class UserControler extends Controller
{

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => [
                'required',
                'min:8',
                'regex:/^(?=.*[A-Za-z])(?=.*\d).+$/',
                'confirmed',
            ]
        ];
        $validator = Validator::make($request->all(), $rules, $messages = [
            'required' => ':attribute обязательное поля',
            'unique' => ':attribute данное поле занято',
            'email' => ':attribute поле должен содержать существующую почту',
            'password' => 'Пароль должен содержать минимум 8 символов, а так же иметь 1 букву и 1 цифру'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'id_role' => 1,
        ]);

        $token = $user->createToken($request->name)->plainTextToken;

        return response()->json(['token' => $token]);
    }

    public function logout()
    {
        Auth::user()->currentToken()->delete();

        return response()->json('complited');
    }

    public function auth(Request $request)
    {
        $user = User::where('email', $request->email)->first();


        if (Hash::check($request->password, $user->password))
            return response()->json($user->createToken('token')->plainTextToken);
    }

    public function update_file(Request $request, $id)
    {
        if ($request->hasFile('ava')) {
            $user = User::FindOrFail($id);

            $imageName = Str::random(32) . "." . $request->ava->getClientOriginalExtension();
            $user->update(['ava' => $imageName]);

            Storage::disk('public')->put($imageName, file_get_contents($request->ava));

            return response()->json($user);
        }
        return response()->json('uncomplited');
    }
}
пш