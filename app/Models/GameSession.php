<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameSession extends Model
{
    //
    protected $fillable = [
        'id',
        'data',
        'bestiary',
        'imgs',
        'DM'
    ];  
}
