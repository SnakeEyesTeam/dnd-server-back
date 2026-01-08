<?php

namespace App\Http\Middleware;

use App\Models\ban;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class BanMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->is_baned == 1) {
            $Bid = Auth::user()->ban_id;
            $bans = Ban::where("id", $Bid)->get();
            $admiN = User::where("id", $bans->value("Aid"))->value("name");
            $reasan = $bans->value("Desc");
            $unban_time = $bans ->value("unban_time");

            return response()->json(['message' => 'Ты забанен ' .$admiN  . ' по причине ' . $reasan  . ' бан истекает:' . $unban_time], 403);
        }

        return $next($request);
    }

}
