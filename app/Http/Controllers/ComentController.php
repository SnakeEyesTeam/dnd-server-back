<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Str;

class ComentController extends Controller
{
    public function show(string $id)
    {
        return response()->json(["data" => Comment::where("post_id", $id)->all()]);
    }

    public function store(Request $request)
    {
        $file = $request->file('files');
        $randomName = Str::random(20);

        $extension = $file->getClientOriginalExtension();

        $fileName = $randomName . '.' . $extension;

        $path = $file->storeAs('comment_file', $fileName);

        Comment::create([
            'content' => $request->payload_content,
            'files' => $path,
            'post_id' => $request->post_id
        ]);
    }


    public function update(Request $request, string $id)
    {
        Comment::where('id', $id)->update([
            'content' => $request->payload_content
        ]);
    }


    public function destroy(string $id)
    {
        Comment::destroy($id);
    }
}
