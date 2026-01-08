<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_session extends Model
{
     protected $table = 'user_sessions';

    protected $fillable = [
        'user_id',
        'session_token',
        'ip_address',
        'last_activity',
    ];

    public $timestamps = false; // если не используете created_at/updated_at

    // Связь с пользователем
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
