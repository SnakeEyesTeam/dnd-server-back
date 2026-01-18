<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Str;

class ComentController extends Controller
{
    public function show(string $id)
    {
        $comments = Comment::where("post_id", $id)->orderByDesc('created_at')->get();
        $finaldata = [];

        foreach ($comments as $comment) {
            $finaldata[] = array_merge(
                $comment->toArray(),
                ['user' => $comment->user]
            );
        }

        return response()->json($finaldata);
    }

    public function store(Request $request, $id)
    {
        // $file = $request->file('files');
        // $randomName = Str::random(20);

        // $extension = $file->getClientOriginalExtension();

        // $fileName = $randomName . '.' . $extension;

        // $path = $file->storeAs('comment_file', $fileName);

        $comment = Comment::create([
            'content' => $request->payload_content,
            'post_id' => $id,
            'user_id' => auth()->user()->id
        ]);

        return response()->json(array_merge(
            $comment->toArray(),
            ['user' => auth()->user()]
        ), 200);
    }


    public function update(Request $request, string $id)
    {
        Comment::where('id', $id)->update([
            'content' => $request->payload_content
        ]);
        $comment = Comment::find($id);

        return response()->json(array_merge($comment->toArray(), ['user' => $comment->user]), 200);
    }


    public function destroy(string $id)
    {
        Comment::destroy($id);
    }
}
