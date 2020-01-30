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

        $hasTitleError = $title === '' || mb_strlen($title) >= 20;
        $hasContentError = $content === '' || mb_strlen($content) >= 30;
        $hasDraftError = !is_bool($draft);
        if ($hasTitleError || $hasContentError || $hasDraftError) {
            return response()->json(['result' => 'error'], 400);
        }

        DB::table('articles')->insert([
             'title' => $title,
             'content' => $content,
             'draft' => $draft,
        ]);

        return response()->json(['result' => 'ok']);
    }
}
