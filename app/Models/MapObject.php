<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapObject extends Model
{
    protected $table = 'objects';
    protected $fillable = [
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