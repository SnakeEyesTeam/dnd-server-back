<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    //
    protected $fillable = [
        'id',
        'name',
        'path',
        'initiative',
        'user_id'
    ];

    public $timestamps = false;
}
