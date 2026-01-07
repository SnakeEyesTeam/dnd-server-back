<?php

namespace App\Http\Controllers;

use Auth;
use Validator;

use App\Models\Ban;
use App\Models\User;
use App\Models\post;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Str;

class ProfileController extends Controller
{
    //
    public function update_user(Request $request, $id)
    {
        $user = User::FindOrFail($id);
        if ($request->hasFile('ava')) {
            $imageName = Str::random(32) . "." . $request->ava->getClientOriginalExtension();
            $user->update(['ava' => $imageName]);

            Storage::disk('public')->put($imageName, file_get_contents($request->ava));

            return response()->json($user);
        } else {
            return response()->json('uncomplited');
        }
    }

    public function change_password(Request $request)
    {
        $rules = [
            'password' => [
                'required',
                'min:8',
                'regex:/^(?=.*[A-Za-z])(?=.*\d).+$/',
                'confirmed',
            ]
        ];
        $validator = Validator::make($request->all(), $rules, $messages = [
            'password' => 'Пароль должен содержать минимум 8 символов, а так же иметь 1 букву и 1 цифру'
        ]);

        $userId = Auth::user()->id;
        User::where('id', $userId)->update(['password' => Hash::make($request->password)]);
    }


    public function ban(Request $request, $id)
    {
        $user = User::find($id);

        if ($user && $user->is_baned === 0) {
            Ban::create([
                'user_id' => $user->id,
                'content' => $request->input('content', 'Блокировка по решению администратора'),
                'admin_id' => Auth::user()->id,
                'ban_time' => now(),
                'unban_time' => $request->unban,
            ]);

            $user->is_baned = true;
            $ban_id = Ban::where("user_id", $user->id)->value("id");
            $user->ban_id = $ban_id;

            $user->save();
            return response()->json('ban success');
        } elseif ($user && $user->is_baned === 1) {
            $user->is_baned = false;
            $user->ban_id = null;
            $user->save();
            Ban::where('user_id', $user->id)->delete();

            return response()->json('Unbundle');
        } else {
            return response()->json('User not found');
        }
    }

    public function info()
    {
        return response()->json(["Users" => User::where('id', Auth::user()->id)->get()]);
    }

    public function post(Request $request)
    {
        return response()->json(["Post" => post::where('user_id',Auth::user()->id)->get()]);
    }
}
