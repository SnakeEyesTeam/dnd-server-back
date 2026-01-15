<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use DB;

class FollowController extends Controller
{
    public function follow($userId)
    {
        $currentUser = auth()->user();

        $userToFollow = User::find($userId);

        if (!$userToFollow) {
            return response()->json(['code' => 'error'], 404);
        }

        if ($currentUser->followings()->where('followed_id', $userId)->exists()) {
            $currentUser->followings()->detach($userId);
            return response()->json(['code' => 'unfollowed']);
        } else {
            $currentUser->followings()->attach($userId);
            return response()->json(['code' => 'followed']);
        }
    }
    public function index()
    {
        $user = User::find(Auth::user()->id);
        $followings = $user->following()
            ->select('users.id', 'users.name', 'users.ava')
            ->get();

        return response()->json($followings);
    }

    public function myFollow($id)
    {
        return DB::table('user_follows')
            ->where('follower_id', )
            ->where('followed_id', $id)->first();
    }
}