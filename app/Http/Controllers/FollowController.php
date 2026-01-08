<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\User;

class FollowController extends Controller
{
    public function Follow($userId)
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
        $userId = Auth::user()->id;
        $user = \App\Models\User::find($userId);
        $subscriptions = $user->following;

        $names = $subscriptions->pluck('name');

        return response()->json(['data' => $names]);
    }
}