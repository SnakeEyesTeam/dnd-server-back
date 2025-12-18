<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Validator;
use App\Models\post;

class PostController extends Controller
{
    //
    public function makePost(Request $request)
    {
        $user = $request->user();
        $rules = [
            'title' => 'required|unique:posts',
            'description' => 'required',
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



        $Post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $user->id,
            'deportament_id' => $request->Did,
        ]);
    }
    public function index(Request $request)
    {
        $posts = Post::where("id", $request->id)->get();

        return response()->json(["Post" => $posts]);
    }

    public function destroy(string $id)
    {
        Post::destroy($id);
    }
}
