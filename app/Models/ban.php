<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ban extends Model
{
    //
    protected $fillable = [
        'admin_id',
        'user_id',
        'content',
        'unban_time',
        'created_at'
    ];

    public $timestamps = false;
}
