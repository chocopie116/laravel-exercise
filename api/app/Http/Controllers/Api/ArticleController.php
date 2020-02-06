<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

        $validation = Validator::make($params, [
            'title' => 'required|string|max:20',
            'content' => 'required|string|max:30',
            'draft' => 'boolean',
            'hashtag_ids.*' => 'integer',
            'image_url' => 'string|url',
        ]);

        if ($validation->fails()) {
            return response()->json(['result' => 'error'], 400);
        }

        $title = $params['title'] ?? '';
        $content = $params['content'] ?? '';
        $draft = $params['draft'] ?? false;
        $hashtagIds = $params['hashtag_ids'] ?? [];
        $imgUrl = $params['image_url'] ?? '';

        $articleId = DB::table('articles')->insertGetId([
             'title' => $title,
             'content' => $content,
             'draft' => $draft,
             'header_image_url' => $imgUrl,
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
