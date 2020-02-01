<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

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

    public function create(Request $request)
    {
        $params = $request->all();
        $title = $params['title'] ?? '';
        $content = $params['content'] ?? '';
        $draft = $params['draft'] ?? false;
        $hashtagIds = $params['hashtag_ids'] ?? [];

        $hasTitleError = $title === '' || mb_strlen($title) >= 20;
        $hasContentError = $content === '' || mb_strlen($content) >= 30;
        $hasDraftError = !is_bool($draft);
        $hasHashtagIdsError = false;
        foreach ($hashtagIds as $hastagId) {
            if (is_numeric($hastagId)) {
                continue;
            }
            $hasHashtagIdsError = true;
        }
        if ($hasTitleError || $hasContentError || $hasDraftError || $hasHashtagIdsError) {
            return response()->json(['result' => 'error'], 400);
        }

        $articleId = DB::table('articles')->insertGetId([
             'title' => $title,
             'content' => $content,
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
