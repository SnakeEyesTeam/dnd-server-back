<?php

namespace App\Models;

use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Model;

class deportament extends Model
{
    //
    protected $fillable = [
        'id',
        'name',
    ];
    public $timestamps = false;
}
