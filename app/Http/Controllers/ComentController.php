<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Str;

class ComentController extends Controller
{
    public function index()
    {
        return response()->json(["data" => Comment::all()]);
    }

    public function store(Request $request)
    {
        $file = $request->file('files');
        $randomName = Str::random(20);

        $extension = $file->getClientOriginalExtension();

        $fileName = $randomName . '.' . $extension;

        $path = $file->storeAs('comment_file', $fileName);

        Comment::create([
            'content' => $request->contents,
            'files' => $path,
            'post_id' => $request->post_id
        ]);
    }


    public function update(Request $request, string $id)
    {
        Comment::where('id', $id)->update([
            'content' => $request->contents
        ]);
    }


    public function destroy(string $id)
    {
        Comment::destroy($id);
    }
}
