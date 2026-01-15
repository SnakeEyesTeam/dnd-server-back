<?php

namespace App\Http\Controllers;

use App\Models\Departament;
use App\Models\post;
use Illuminate\Http\Request;
use Validator;

class DepartamentController extends Controller
{
    public function fixed($id)
    {
        $post = Post::select(['title', 'id', 'tags', 'description', 'user_id'])->where('departament_id', $id)->first();
        return response()->json([
            array_merge(
                $post->toArray(),
                ['user' => $post->user]
            )
        ]);
    }
    //
    public function index()
    {
        $forum = Departament::all();
        $finalData = [];

        foreach ($forum as $value) {
            $post = Post::select(['title', 'id', 'tags', 'description', 'user_id'])->where('departament_id', $value->fixed_post)->first();
            $finalData[] = array_merge(
                $value->toArray(),
                ['count' => Post::where('departament_id', $value->id)->count()],
                [
                    'fixed' => array_merge(
                        $post->toArray(),
                        ['user' => $post->user]
                    )
                ],
            );
        }
        return response()->json($finalData);
    }

    public function show($id, Request $request)
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

        $posts = $query->select(['id', 'title', 'description', 'tags', 'user_id'])->skip($skip)->take($take)->get();
        $finaldata = [];
        foreach ($posts as $post) {
            $finaldata[] = array_merge(
                $post->toArray(),
                ['user' => ['name' => $post->user->name]]
            );
        }

        return response()->json(['data' => $finaldata, 'isEnd' => $query->count() <= $skip + $take]);
    }
}
