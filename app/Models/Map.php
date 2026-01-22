<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
    //
    protected $fillable = [
        'id',
        'name',
        'path',
        'user_id',
        'source_id'
    ];

    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id');
    }
}
