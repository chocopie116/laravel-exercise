<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles  = Article::with(['user', 'hashtags'])
            ->published()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json($articles);
    }

    public function show($id)
    {
        $article  = Article::with(['user', 'hashtags'])
            ->published()
            ->findOrFail($id);

        return response()->json($article);
    }

    public function someones(Request $request, $userId)
    {
        $articles  = Article::with(['user', 'hashtags'])
            ->published()
            ->where('user_id', '=', $userId)
            ->get();

        return response()->json($articles);
    }
}
