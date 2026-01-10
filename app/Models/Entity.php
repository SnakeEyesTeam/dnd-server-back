<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    //
    protected $fillable = [
        'name',
        'path',
        'iniciative',
        'discription',
        'size',
        'user_id',
        'source_id'
    ];

    public $timestamps = false;
}
