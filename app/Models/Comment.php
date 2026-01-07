<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $fillable = [
        'id',
        'content',
        'files',
        'post_id'
    ];
    public $timestamps = false;
}
