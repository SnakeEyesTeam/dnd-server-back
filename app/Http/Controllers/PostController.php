<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\post;
use Str;
use App\Models\Like;
use Auth;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $user = $request->user();

        $rules = [
            'title' => 'required',
            'payload_content' => 'required',
            'tags' => 'nullable',
            'files' => 'nullable|array',
        ];

        $validator = Validator::make($request->all(), $rules, [
            'required' => ':attribute обязательное поле',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'errors' => $validator->errors()
                ],
                400
            );
        }

        $paths = [];

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $randomName = Str::random(20);
                $extension = $file->getClientOriginalExtension();
                $fileName = $randomName . '.' . $extension;
                $path = $file->storeAs('post_file', $fileName);
                $paths[] = $path;
            }
        }

        $tagsInput = $request->input('tags');

        if (is_array($tagsInput)) {
            $tagsString = implode(',', $tagsInput);
        } elseif (is_string($tagsInput)) {
            $tagsString = $tagsInput;
        } else {
            $tagsString = '';
        }

        $filesString = !empty($paths) ? implode(',', $paths) : null;

        Post::create([
            'title' => $request->title,
            'files' => $filesString,
            'content' => $request->payload_content,
            'description' => $request->description,
            'tags' => $tagsString,
            'user_id' => $user->id,
            'departament_id' => $request->department,
        ]);

        return response()->json(null, 200);
    }
    public function index($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(null, 222);
        }

        return response()->json(array_merge($post->toArray(), ['user' => $post->user], ['likes' => Like::where('post_id', $id)->count()]));
    }

    public function destroy(string $id)
    {
        $user = Auth::user();
        $post = Post::find($id);

        if (!$post) {
            return response()->json(["code" => 'error'], 404);
        }


        if ($post->user_id === $user->id || $user->role_id === 2) {
            $post->delete();
            return response()->json(null, 200);
        } else {
            return response()->json(null, 403);
        }
    }

    public function likeAction(Request $request)
    {
        $userId = Auth::user()->id;
        $postId = $request->id;

        $existingLike = Like::where('user_id', $userId)
            ->where('post_id', $postId)
            ->first();

        if (!$existingLike) {
            Like::create([
                'post_id' => $postId,
                'user_id' => $userId,
            ]);
            return response()->json(null, 200);
        } else {
            $existingLike->delete();
            return response()->json(null, 200);
        }
    }
    public function isLike($postId)
    {
        $like = Like::where('post_id', $postId)
            ->where('user_id', Auth::user()->id)
            ->first();

        if ($like) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }
}
