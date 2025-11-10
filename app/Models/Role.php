<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use HasFactory;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = [
        'name'
    ];

}
