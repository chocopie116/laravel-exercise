<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles  = Article::published()->get();

        foreach ($articles as $article) {
            $article->user;
        }

        return response()->json($articles);
    }

    public function show($id)
    {
        $article  = DB::table('articles')->where('id', '=', $id)->where('draft', '=', false)->get();

        return response()->json($article[0]);
    }

    public function someones(Request $request, $userId)
    {
        $articles  = DB::table('articles')
            ->where('user_id', '=', $userId)
            ->where('draft', '=', false)
            ->get();

        return response()->json($articles);
    }
}
