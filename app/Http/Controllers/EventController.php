<?php

namespace App\Http\Controllers;

use App\Events\EventEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventController extends Controller
{
    //
    public function throwEvent(Request $request)
    {
        broadcast(new EventEvent($request->event));
        return response()->json(true);
    }
}
