<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    public function index()
    {
        $articles= [
            [
                'id' => 1,
                'title' => 'this is title',
                'body' => 'this is article main content.'
            ],
            [
                'id' => 2,
                'title' => 'this is title',
                'body' => 'this is article main content.'
            ]
        ];

        return response()->json($articles);
    }

    public function show($id)
    {
        $article = [
            'id' => 1,
            'title' => 'this is title',
            'body' => 'this is article main content.'
        ];

        return response()->json($article);
    }

    public function create()
    {
        return response()->json(['result' => 'ok']);
    }
}
