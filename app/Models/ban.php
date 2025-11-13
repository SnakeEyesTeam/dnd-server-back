<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ban extends Model
{
    //
    protected $fillable = [
        'Aid',
        'Uid',
        'Desc',
        'unban_time',
        'created_at'
    ];

    public $timestamps = false;
}
