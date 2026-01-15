<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Validator;

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
                // 'confirmed',
            ],
            'confirmPassword' => [
                'required',
                'min:8',
                'regex:/^(?=.*[A-Za-z])(?=.*\d).+$/',
                // 'confirmed',
            ]
        ];
        $validator = Validator::make($request->all(), $rules, $messages = [
            'required' => ':attribute - обязательное поля',
            'unique' => ':attribute данное поле занято',
            'email' => ':attribute поле должен содержать существующую почту',
            'password' => 'Пароль должен содержать минимум 8 символов, а так же иметь 1 букву и 1 цифру'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

        $user = User::create(
            array_merge(
                [
                    'name' => $request->name,
                    'email' => $request->email,
                ],
                [
                    'password' => Hash::make($request->password),
                    'role_id' => 1,
                ]
            )
        );

        $token = $user->createToken($request->name)->plainTextToken;

        return response()->json(['token' => $token], 200);
    }


    public function logout(Request $request)
    {
        $user = $request->user();



        if ($user && $request->user()->currentAccessToken()) {
            $request->user()->currentAccessToken()->delete();
        }

        return response()->json(['message' => 'success']);
    }

    public function auth(Request $request)
    {
        $nameOrEmail = $request->input('nameOrEmail');

        $user = User::where('email', $nameOrEmail)
            ->orWhere('name', $nameOrEmail)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Неверные учетные данные'], 401);
        }

        $token = $user->createToken('token')->plainTextToken;

        return response()->json(['token' => $token], 200);
    }

    public function index(Request $request)
    {
        $search = $request->input('search', null);
        $skip = (int) $request->input('skip', 0);
        $take = (int) $request->input('take', 10);

        $usersQuery = User::query()->select(['name', 'ava', 'id']);

        if ($search) {
            $usersQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }

        $users = $usersQuery->skip($skip)->take($take)->get();

        return response()->json(['data' => $users, 'isEnd' => $usersQuery->count() >= $skip]);
    }
}