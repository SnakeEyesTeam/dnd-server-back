<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    //
    protected $fillable = [
        'name',
        'path',
        'initiative',
        'description',
        'idInBestiary',
        'size',
        'user_id',
        'source_id'
    ];

    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id');
    }

    public $timestamps = false;
}
