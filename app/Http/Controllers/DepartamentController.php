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
        return response()->json(["data" => Departament::all()]);
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

        return response()->json(["data" => $posts]);
    }
}
