<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'content',
        'user_id',
        'description',
        'tags',
        'departament_id',
        'files'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }
    public function department()
    {
        return $this->belongsTo(departament::class, "departament_id");
    }

    public function _likes()
    {
        return $this->belongsToMany(
            Like::class,
            'likes',
            'user_id',
            'post_id',
        );
    }
}
