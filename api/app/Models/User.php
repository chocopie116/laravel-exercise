<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $hidden = [
        'email', 'password', 'remember_token', 'created_at', 'updated_at', 'email_verified_at'
    ];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
