<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles  = DB::select('select * from articles');

        return response()->json($articles);
    }

    public function show($id)
    {
        $article  = DB::select("select * from articles where id = $id");

        return response()->json($article);
    }

    public function create(Request $request)
    {
        $params = $request->all();

        //パラメータが渡ってきてるか確認するためのdebugコード
        //var_dump($params);
        //exit;

        $title = $params['title'];
        $content = $params['content'];
        $sql= "insert into articles (title, content) values (\"$title\", \"$content\")";
        DB::insert($sql);

        return response()->json(['result' => 'ok']);
    }
}
