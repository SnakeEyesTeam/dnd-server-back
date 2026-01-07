<?php

namespace App\Models;

use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Model;

class departament extends Model
{
    //
    protected $fillable = [
        'id',
        'name',
        'img'
    ];
    public $timestamps = false;
}
