<?php

namespace App\Http\Controllers;

use App\Models\Departament;
use App\Models\post;
use Illuminate\Http\Request;
use Validator;

class DepartamentController extends Controller
{
    //
    public function index()
    {
        return response()->json(["Departament" => Departament::all()]);
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
            "name" => $request->name
        ]);
    }

    public function getDepartament($id, Request $request)
    {
        $query = Post::where('departament_id', $id);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                    ->orWhere('content', 'like', "%$search%");
            });
        }


        if ($request->has('date') && $request->date != null) {
            $date = $request->input('date');
            $query->whereDate('created_at', $date);
        }

        if ($request->has('tags')) {
            $tags = explode(',', $request->input('tags'));
            $query->where(function ($q) use ($tags) {
                foreach ($tags as $tag) {
                    $tag = trim($tag);
                    $q->where('tags', 'like', "%{$tag}%");
                }
            });
        }

        $skip = (int) $request->input('skip', 0);
        $take = (int) $request->input('take', 10);

        $posts = $query->skip($skip)->take($take)->get();

        return response()->json($posts);
    }
}
