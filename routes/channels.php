<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('session.{id}', function ($_, $id) {
    return true;
});
