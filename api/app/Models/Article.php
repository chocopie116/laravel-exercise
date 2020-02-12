<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public function scopePublished(Builder $query)
    {
        return $query->where('draft', false);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
