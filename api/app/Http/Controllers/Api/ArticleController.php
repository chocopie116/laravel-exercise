<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use DB;

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

    public function create()
    {
        DB::insert("insert into articles (title, content) values ('this is stored title', 'this is stored content')");

        return response()->json(['result' => 'ok']);
    }
}
