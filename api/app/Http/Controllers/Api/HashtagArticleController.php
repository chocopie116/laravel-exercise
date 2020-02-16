<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;

class HashtagArticleController extends Controller
{
    public function index($hashtagId)
    {
        $articles = Article::with(['user', 'hashtags'])
            ->published()
            ->join('hashtag_articles', 'articles.id', '=', 'hashtag_articles.article_id')
            ->where('hashtag_articles.hashtag_id', '=', $hashtagId)
            ->get();

        return response()->json($articles);
    }
}
