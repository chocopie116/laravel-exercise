<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
