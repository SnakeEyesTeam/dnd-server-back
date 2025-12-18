<?php

namespace App\Http\Controllers;

use App\Models\ban;
use Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\User;
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
            'role_id' => 1,
        ]);

        $token = $user->createToken($request->name)->plainTextToken;

        return response()->json(['token' => $token]);
    }


    public function logout(Request $request)
    {
        $user = $request->user();



        if ($user && $request->user()->currentAccessToken()) {
            $request->user()->currentAccessToken()->delete();
        }

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function auth(Request $request)
    {
        $user = User::where('email', $request->email)->first();



        if (Hash::check($request->password, $user->password)) {
            $token = $user->createToken('token')->plainTextToken;
            Auth::login($user);
            return response()->json($token);
        }

    }

    public function update_user(Request $request, $id)
    {
        $user = User::FindOrFail($id);
        if ($request->hasFile('ava')) {
            $imageName = Str::random(32) . "." . $request->ava->getClientOriginalExtension();
            $user->update(['ava' => $imageName]);

            Storage::disk('public')->put($imageName, file_get_contents($request->ava));

            return response()->json($user);
        } else {
            return response()->json('uncomplited');
        }
    }

    public function change_password(Request $request)
    {
        $rules = [
            'password' => [
                'required',
                'min:8',
                'regex:/^(?=.*[A-Za-z])(?=.*\d).+$/',
                'confirmed',
            ]
        ];
        $validator = Validator::make($request->all(), $rules, $messages = [
            'password' => 'Пароль должен содержать минимум 8 символов, а так же иметь 1 букву и 1 цифру'
        ]);

        $userId = Auth::user()->id;
        User::where('id', $userId)->update(['password' => Hash::make($request->password)]);
    }



    public function ban(Request $request, $id)
    {
        $user = User::find($id);

        if ($user && $user->is_baned === 0) {
            Ban::create([
                'user_id' => $user->id,
                'Desc' => $request->input('desc', 'Блокировка по решению администратора'),
                'admin_id' => Auth::user()->id,
                'ban_time' => now(),
                'unban_time' => $request->unban,
            ]);

            $user->is_baned = true;
            $ban_id = Ban::where("user_id", $user->id)->value("id");
            $user->ban_id = $ban_id;

            $user->save();
            return response()->json('ban success');
        } elseif ($user && $user->is_baned === 1) {
            $user->is_baned = false;
            $user->ban_id = null;
            $user->save();
            Ban::where('user_id', $user->id)->delete();

            return response()->json('Unbundle');
        } else {
            return response()->json('User not found');
        }
    }
}