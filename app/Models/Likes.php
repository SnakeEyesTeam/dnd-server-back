<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Likes extends Model
{
    //
    public $timestamps = false;

    protected $fillable = [
        'id',
        'posts_id',
        'user_id',
    ];
}
