<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class departament extends Model
{
    //
    protected $fillable = [
        'id',
        'name',
        'img',
        'fixed_post'
    ];
    public $timestamps = false;
}
