<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Characters extends Model
{
    //
    protected $fillable = [
        'id',
        'name',
        'img',
        'initiative',
        'user_id'
    ];
    public $timestamps = false;
}
