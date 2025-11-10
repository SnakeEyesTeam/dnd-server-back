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

        $user = $request->user();

        $Post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'Uid'=>$user->id,
            'Did'=>$request->Did,
        ]);
    }
    public function index(){
        $posts = Post::get();

        dd($posts);
    }
}
