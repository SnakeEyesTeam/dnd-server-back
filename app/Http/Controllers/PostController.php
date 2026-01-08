<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Validator;
use App\Models\post;
use Str;
use App\Models\Likes;
use Auth;

class PostController extends Controller
{
    //
    public function makePost(Request $request)
    {
        $user = $request->user();
        $rules = [
            'title' => 'required|unique:posts',
            'contents' => 'required',
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


        $file = $request->file('files');
        $randomName = Str::random(20);

        $extension = $file->getClientOriginalExtension();

        $fileName = $randomName . '.' . $extension;

        $path = $file->storeAs('post_file', $fileName);

        $Post = Post::create([
            'title' => $request->title,
            'files' => $path,
            'content' => $request->contents,
            'user_id' => $user->id,
            'departament_id' => $request->Did,
        ]);
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

    public function like(Request $request)
    {
        $userId = Auth::user()->id;
        $postId = $request->id;

        $existingLike = Likes::where('user_id', $userId)
            ->where('posts_id', $postId)
            ->first();

        if (!$existingLike) {
            Likes::create([
                'posts_id' => $postId,
                'user_id' => $userId,
            ]);
            return response()->json(['message' => 'Лайк добавлен']);
        } else {
            $existingLike->delete();
            return response()->json(['message' => 'Лайк удален']);
        }
    }
}
