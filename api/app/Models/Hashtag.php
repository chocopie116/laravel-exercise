<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hashtag extends Model
{
    public function articles()
    {
        return $this->belongsToMany(Article::class, 'hashtag_articles', 'hashtag_id', 'article_id');
    }
}
