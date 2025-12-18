<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class maps extends Model
{
    //
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'path',
    ];
}
