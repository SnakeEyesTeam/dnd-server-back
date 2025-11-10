<?php

namespace App\Http\Controllers;

use App\Models\deportament;
use Illuminate\Http\Request;
use Validator;

class DeportamentController extends Controller
{
    //
    public function makeDep(Request $request)
    {
        $rules = [
            'name' => 'required|unique:deportaments',
        ];
        $validator = Validator::make($request->all(), $rules, $messages = [
            'required' => ':attribute обязательное поля',
            'unique' => ':attribute данное поле занято',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }


        Deportament::create([
            "name"=>$request->name
        ]);
    }
}
