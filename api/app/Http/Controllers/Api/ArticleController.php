<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateArticleRequest;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    public function index()
    {
        $articles  = DB::table('articles')->where('draft', '=', false)->get();

        return response()->json($articles);
    }

    public function show($id)
    {
        $article  = DB::table('articles')->where('id', '=', $id)->where('draft', '=', false)->get();

        return response()->json($article[0]);
    }

    public function create(CreateArticleRequest $request)
    {
        /**
         * バリデーション済のリクエストであることが担保されている
         * validation終了後のパラメータが取得できる
         */
        $params = $request->validated();

        $draft = $params['draft'] ?? false;
        $hashtagIds = $params['hashtag_ids'] ?? [];

        $articleId = DB::table('articles')->insertGetId([
             'title'   => $params['title'],
             'content' => $params['content'],
             'draft' => $draft,
        ]);

        foreach ($hashtagIds as $hashtagId) {
            DB::table('hashtag_articles')->insert([
                'article_id' => $articleId,
                'hashtag_id' => $hashtagId,
            ]);
        }

        return response()->json(['result' => 'ok']);
    }
}
