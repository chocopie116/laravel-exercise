<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use DB;

class HashtagArticleController extends Controller
{
    public function index($hashtagId)
    {
        $articles = DB::table('hashtag_articles')
        ->join('articles', 'articles.id', '=', 'hashtag_articles.article_id')
        ->select('articles.*')
        ->where('hashtag_articles.hashtag_id', '=', $hashtagId)
        ->get();

        return response()->json($articles);
    }
}
