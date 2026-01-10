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
            'title' => 'required|unique:posts',
            'payload_content' => 'required',
            'tags' => 'nullable', 
            'files' => 'nullable|array', 
            'files.*' => 'file', 
        ];

        $validator = Validator::make($request->all(), $rules, [
            'required' => ':attribute обязательное поле',
            'unique' => ':attribute данное поле занято',
            'file' => 'Файл должен быть файлом', 
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => $validator->errors()
            ], 422);
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

        $Post = Post::create([
            'title' => $request->title,
            'files' => $filesString,
            'content' => $request->payload_content,
            'tags' => $tagsString,
            'user_id' => $user->id,
            'departament_id' => $request->Did,
        ]);

        return response()->json(['code' => 'success']);
    }
    public function index(Request $request)
    {
        $posts = Post::where("id", $request->id)->get();

        return response()->json(["data" => $posts, 'code' => 'success']);
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
            return response()->json(["code" => 'success']);
        } else {
            return response()->json(["code" => 'error'], 403);
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
            return response()->json(['message' => 'Лайк добавлен']);
        } else {
            $existingLike->delete();
            return response()->json(['message' => 'Лайк удален']);
        }
    }
    public function isLike($postId)
    {
        $like = Like::where('post_id', $postId)
            ->where('user_id', Auth::user()->id)
            ->first();

        if ($like) {
            return response()->json(['data' => true]);
        } else {
            return response()->json(['data' => false]);
        }
    }
}
