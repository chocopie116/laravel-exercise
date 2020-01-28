<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles  = DB::table('articles')->get();

        return response()->json($articles);
    }

    public function show($id)
    {
        $article  = DB::table('articles')->where('id', '=', $id)->get();

        return response()->json($article[0]);
    }

    public function create(Request $request)
    {
        $params = $request->all();
        $title = $params['title'];
        $content = $params['content'];

        DB::table('articles')->insert([
             'title' => $title,
             'content' => $content,
        ]);

        return response()->json(['result' => 'ok']);
    }
}
