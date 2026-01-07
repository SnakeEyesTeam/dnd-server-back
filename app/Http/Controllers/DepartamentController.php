<?php

namespace App\Http\Controllers;

use App\Models\Departament;
use Illuminate\Http\Request;
use Validator;

class DepartamentController extends Controller
{
    //
    public function index(){
        return response()->json(["Departament"=>Departament::all()]);
    }
    public function makeDep(Request $request)
    {
        $rules = [
            'name' => 'required|unique:Departaments',
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


        Departament::create([
            "name"=>$request->name
        ]);
    }
}
